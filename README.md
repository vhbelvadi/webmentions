# Webmentions

[According to the W3C](https://www.w3.org/TR/webmention/) Webmentions are an open web standard for conversations and interactions across the web, a powerful building block used for a growing distributed network of peer-to-peer comments, likes, reposts, and other responses across the web.

Popular across the [IndieWeb](https://indieweb.org/Webmention) as a means of enabling cross-site conversations, webmentions allow individuals to inform, and be informed by, other websites about activities and publications on websites and across social media platforms. In practice most people use webmentions in conjunction with services like [webmention.io](https://webmention.io) and [Bridgy](https://brid.gy).

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
