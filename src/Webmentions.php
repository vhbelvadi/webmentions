<?php

namespace Vhbelvadi\Webmentions;

use GuzzleHttp\Client;

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
