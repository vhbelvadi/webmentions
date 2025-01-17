<?php

namespace Vhbelvadi\Webmentions;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        \Vhbelvadi\Webmentions\Webmentions::class
    ];
}
