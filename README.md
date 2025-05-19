# Webmentions

![Statamic webmentions overview](https://statamic.com/storage/products/5G37zMEu2lHAyrtaz5ecDefjVQzdQ99JLJEUoQrc.jpg)

[According to the W3C](https://www.w3.org/TR/webmention/) Webmentions are an open web standard for conversations and interactions across the web, a powerful building block used for a growing distributed network of peer-to-peer comments, likes, reposts, and other responses across the web.

Popular across the [IndieWeb](https://indieweb.org/Webmention) as a means of enabling cross-site conversations, webmentions allow individuals to inform, and be informed by, other websites about activities and publications on websites and across social media platforms. In practice most people use webmentions in conjunction with services like [webmention.io](https://webmention.io) and [Bridgy](https://brid.gy).

***
**Jump to section** • [Installation](https://github.com/vhbelvadi/webmentions#installation) • [Templating](https://github.com/vhbelvadi/webmentions#templating) • [Widget set-up](https://github.com/vhbelvadi/webmentions#widget-new-in-v2) • [Troubleshooting](https://github.com/vhbelvadi/webmentions#troubleshooting) • [Further](https://github.com/vhbelvadi/webmentions#further) (includes [an example set-up](https://github.com/vhbelvadi/webmentions#example-set-up))
***

## Installation

This add-on is for websites built with [Statamic](https://statamic.com).

**Installation** is as normally [recommended by Statamic](https://statamic.dev/extending/addons#installing-an-addon):

```
composer require vhbelvadi/webmentions
```

**Add a link tag** to your website, making sure to update the `<domain.tld>` bit:

```
<link rel="webmention" href="https://webmention.io/<domain.tld>/webmention" />
```

Assuming you have signed up with [webmention.io](https://webmention.io) and added your domain, this tag will work. It is the same tag available directly [from your webmention.io account](https://webmention.io/settings/sites).

## Templating

On your statamic site, use the `{{ webmentions }}` tag passing the appropriate URL. A more detailed explanation follows but as a quick example the following tag works on a reused blog post template:

```
{{ webmentions url={{ current_url}} }}
```

This add-on also provides a `length` modifier that outputs the number of webmentions for the given url. For this and other template tags, see [the example set-up](#example-set-up).

![Statamic webmentions add-on screenshot](https://statamic.com/storage/products/UCeoKVWAur6I2IB59ppvbGTE89rZSOkUXRrVGKwo.png)

## Widget (New in v2!)

This add-on provides a control panel widget. There are two steps to enable it, both standard Statamic procedures:

### Save your API key

Head to your [webmention.io settings](https://webmention.io/settings) and copy your API key.

Next, add a value your `.env` file like so:

```
WEBMENTION_TOKEN=<paste-your-API-key-here>
```

### Set up your widget

In the config file located at `config/statamic/cp.php` add your widget:

```
'widgets' => [ 
        [ 
            'type' => 'webmentions',
            'width' => 50,
            'limit' => 7, // optional
        ], 
    ],
```

If you already have a few widgets set up, you can of course skip the `'widgets => [ ],` block and just add the `webmentions` block for this add-on. The `'limit'` value is optional and defaults to 7 if not provided i.e. the widget will display the seven latest webmentions.

![Webmentions widget](https://statamic.com/storage/products/EGkG8jBZaBHqydUv7weZROKklhJgf0TDAAY7jNkP.png)

Rather than display a feed as is, widget offers a few links: a link to the webmention itself, a link to your post with which the webmention interacts, and a link to edit that post for convenience if you should need it.

The recommended `'width'` value is `50` although the widget works at any other width. The widget will display a helpful blue **NEW** marker if you have any webmentions within the last 3 days.

## Troubleshooting

### Blank page following widget set-up

**If you set up your widget locally** and pushed to your production server please run `composer update`.

**If you set up your widget on production**—you daredevil—or if you did so locally but forgot to add your API key, check that your `.env` file has the proper API set-up.

*Got any suggestions for common problems? Please [let me know](mailto:hello@vhbelvadi.com) or edit this section and submit a pull request.*

## Further

The following payload is sent via webhooks:

```
{
  "secret": "1234abcd",
  "source": "http://rhiaro.co.uk/2015/11/1446953889",
  "target": "http://aaronparecki.com/notes/2015/11/07/4/indiewebcamp",
  "post": {
    "type": "entry",
    "author": {
      "name": "Amy Guy",
      "photo": "http://webmention.io/avatar/rhiaro.co.uk/829d3f6e7083d7ee8bd7b20363da84d88ce5b4ce094f78fd1b27d8d3dc42560e.png",
      "url": "http://rhiaro.co.uk/about#me"
    },
    "url": "http://rhiaro.co.uk/2015/11/1446953889",
    "published": "2015-11-08T03:38:09+00:00",
    "name": "repost of http://aaronparecki.com/notes/2015/11/07/4/indiewebcamp",
    "repost-of": "http://aaronparecki.com/notes/2015/11/07/4/indiewebcamp",
    "wm-property": "repost-of"
  }
}
```

This means you can use, for example with Statamic Antlers, the following tags directly:

```
{{ mentions }} {{ wm-property }} {{ published }} {{ name }} {{ url }}
```

And you can use the following author-specific tags within an `{{ author }} ... {{ /author }}` block:

```
{{ photo }} {{ name }} {{ url }}
```

**Note** that although the `{{ name }}` and `{{ url }}` tags appear in both places, as shown in the sample payload above, they contain different pieces of information.

### Example set-up

As a live example, check out the webmentions [on this webpage](https://vhbelvadi.com/indieweb-carnival-friction) where the implementation looks something like this:

```
{{ nocache }}
  {{ webmentions url="{{ current_url }}" }}
    {{ if !no_results }}
      <div>{{ mentions | length }} webmentions</div>
      <div>
        {{ mentions }}
          <a href="{{ url }}" class="transition duration-500 group text-center">
            {{ author }}
                <img src="{{ photo }}">
            {{ /author }}
            <div>
              {{ switch(
                  ( wm-property == "in-reply-to" ) => 'replied',
                  ( wm-property == "like-of" ) => 'liked',
                  ( wm-property == "repost-of" ) => 'shared',
                  ( wm-property == "bookmark-of" ) => 'bookmarked',
                  ( wm-property == "mention-of" ) => 'discussed',
                  ( wm-property == "rsvp" ) => 'rsvp'
              )}}
            </div>
          </a>
        {{ /mentions }}
      </div>
    {{ /if }}
  {{ /webmentions }}
{{ /nocache }}
```

The `{{ nocache }} ... {{ /nocache }}` block is not necessary if you are not using Statamic caching.

***

This add-on was originally created by [Matt Rothenberg](https://github.com/mattrothenberg).
