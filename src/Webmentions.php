<?php

namespace Vhbelvadi\Webmentions;

use GuzzleHttp\Client;
use Statamic\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class Webmentions extends \Statamic\Tags\Tags
{
    public function index()
    {
        if (!$this->params->get('url')) {
            return false;
        }

        $json = $this->fetch('/api/mentions.jf2');
        $children = $json['children'];
        return $children ? ['mentions' => $children] : [];
    }

    public function count()
    {
        if (!$this->params->get('url')) {
            return false;
        }

        return $this->fetch('/api/count');
    }
    
    private function fetch(string $endpoint): array
    {
        $client = new Client([
            'base_uri' => 'https://webmention.io/'
        ]);
        $res = $client->request('GET', $endpoint, [
            'query' => ['target' => $this->params->get('url')],
            'http_errors' => false
        ]);

        return json_decode($res->getBody(), true);
    }
}

class WebmentionsWidget extends Widget
{
    /**
     * @return string|\Illuminate\View\View 
     **/
    public function html()
    {
        $atomFeed = 'https://webmention.io/api/mentions.atom?token=' . env('WEBMENTION_TOKEN');
        $limit = $this->config('limit') ?? 7;

        if (!$atomFeed) {
            return "Error! Please check your webmention.io access token.";
        }

        $key = 'vhbelvadi-webmentions-'.md5($atomFeed.$limit);

        $data = Cache::rememberWithExpiration($key, function() use ($atomFeed, $limit) {
            $feed = $this->getFeed($atomFeed);

            $data = [
                'title' => $feed->get_title(),
                'summary' => $feed->get_description(),
                'mentions' => $feed->get_items(0, $limit),
                'recency' => $this->config('recency'),
            ];

            return [25 => $data];
        });

        return view('vhbelvadi::widgets.webmentions', $data);
    }

    /**
     * Return the feed object.
     *
     * @param string $url
     * @return \SimplePie
     */
    public function getFeed($url)
    {
        $simplePie = new \SimplePie();
        $simplePie->enable_cache(false);
        $simplePie->set_feed_url($url);
        $simplePie->init();

        return $simplePie;
    }
}