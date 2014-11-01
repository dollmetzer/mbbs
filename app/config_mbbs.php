<?php
/**
 * Configuration for the dev enviroment
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2006-2014, Dirk Ollmetzer
 * @package Application
 */

include __DIR__ . '/config.php';

// URL Settings
define('URL_BASE', $_SERVER['SERVER_NAME']);
define('URL_MEDIA', $_SERVER['SERVER_NAME']);
define('URL_REWRITE', false);
