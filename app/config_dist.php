<?php
/**
 * Sample configuration
 *
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2006-2018, Dirk Ollmetzer
 * @package Application
 */

// URL Settings
define('URL_BASE', $_SERVER['SERVER_NAME']);
define('URL_MEDIA', $_SERVER['SERVER_NAME']);
define('URL_REWRITE', true);
define('URL_HTTPS', false);

// Path Settings
define('PATH_BASE', realpath(__DIR__ . '/..') . '/');
define('PATH_APP', PATH_BASE . 'app/');
define('PATH_DATA', PATH_BASE . 'data/');
define('PATH_HTDOCS', PATH_BASE . 'htdocs/');
define('PATH_LOGS', PATH_BASE . 'logs/');
define('PATH_TMP', PATH_BASE . 'tmp/');

// External Services

// Application Settings
define('TIMEZONE', 'Europe/Berlin');
define('DEBUG_CLI', false);
define('DEBUG_API', false);
define('DEBUG_REQUEST', false);
define('DEBUG_SESSION', false);
define('DEBUG_CONTENT', false);
define('DEBUG_PERFORMANCE', false);
define('DEBUG_DB', false);

$config = array(
    'title' => 'myMBBS',
    'name' => 'mbbs',
    'themes' => array(
        'frontend',
        'backend'
    ),
    'languages' => array(
        'de',
        'en'
    ),
    'db' => array(
        'master' => array(
            'dsn' => 'mysql:host=localhost;dbname=mbbs',
            'user' => 'dbuser',
            'pass' => 'dbpassword'
        )
    ),
    'quicklogin' => true,
    'register' => array(
        'selfregister' => true,
        'mailcheck' => true,
        'separate_handle' => true,
        'invitation' => false,
    ),
    'tracking' => array(
        'session' => true
    ),
    'mail' => array(
        'admin' => 'your.mail@yourdomain.com',
        'from' => 'your name <your.mail@yourdomain.com>',
        'replyto' => 'your name <your.mail@yourdomain.com>',
    ),
    'media' => array(
        'pictures' => array(
            'maxwidth' => 1280,
            'maxheight' => 1280
        )
    ),

);
