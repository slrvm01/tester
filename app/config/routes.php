<?php

/**
 * Part of app config.
 */

define('ROUTES', serialize([
    [
        'match' => '^$',
        'route' => [
            'controller' => 'home',
            'action' => 'index'
        ]
    ],
    [
        'match' => '^(?P<controller>(test))/?(?P<test_id>[0-9]+)?$',
    ],
    [
        'match' => '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$'
    ]
]));