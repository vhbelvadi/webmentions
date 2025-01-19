<?php

namespace Vhbelvadi\Webmentions;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'vhbelvadi';

    protected $tags = [
        \Vhbelvadi\Webmentions\Webmentions::class
    ];

    protected $widgets = [
        WebmentionsWidget::class
    ];
}
