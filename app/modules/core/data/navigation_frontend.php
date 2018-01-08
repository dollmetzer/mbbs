<?php
return array(
    'home' => array(
        'icon' => 'fa-home',
        'url' => '',
        'group' => array('guest','user'),
        'sort' => 1,
    ),
    'terms' => array(
        'icon' => 'fa-gavel',
        'url' => 'core/index/terms',
        'group' => 'guest',
        'sort' => 96,
    ),
    'privacy' => array(
        'icon' => 'fa-eye',
        'url' => 'core/index/privacy',
        'group' => 'guest',
        'sort' => 97,
    ),
    'imprint' => array(
        'icon' => 'fa-info',
        'url' => 'core/index/imprint',
        'group' => 'guest',
        'sort' => 98,
    ),
    'admin' => array(
        'icon' => 'fa-wrench',
        'url' => 'core/admin',
        'group' => 'administrator',
        'sort' => 99,
    )
);