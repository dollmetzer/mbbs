<?php
/**
 * Configuration for the dev enviroment
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2006-2015, Dirk Ollmetzer
 * @package Application
 */

// URL Settings
define('URL_BASE', $_SERVER['SERVER_NAME']);
define('URL_MEDIA', $_SERVER['SERVER_NAME']);
define('URL_REWRITE', false);

// Path Settings
define('PATH_BASE', realpath( __DIR__ . '/..').'/');
define('PATH_APP', PATH_BASE.'app/');
define('PATH_DATA', PATH_BASE.'data/');
define('PATH_HTDOCS', PATH_BASE.'htdocs/');
define('PATH_LOGS', PATH_BASE.'logs/');

// External Services

// Application Settings
define('TIMEZONE', 'Europe/Berlin');
define('DEBUG_REQUEST', false);
define('DEBUG_SESSION', false);
define('DEBUG_CONTENT', false);
define('DEBUG_PERFORMANCE', false);
define('DEBUG_DB', false);

$config = array(
    'core' => array(
        'title' => 'myMBBS',
        'name' => 'mbbs',
        'standalone' => true,
        'themes' => array(
            'web'
        ),
        'languages' => array(
            'de',
            'en'
        ),
        'db' => array(
            'slave' => array(
                'dsn' => 'mysql:host=localhost;dbname=mbbs',
                'user' => 'root',
                'pass' => 'root'
            )
        ),
        'quicklogin' => true,
        'register' => array(
            'selfregister' => false,
            'mailcheck' => false,
            'invitation' => true,
        ),
        'tracking' => array(
            'session' => true
        ),
        'mail' => array(
            'admin' => 'dirk.ollmetzer@ollmetzer.com',
            'from' => 'handover@ollmetzer.com',
        ),
    )
);
