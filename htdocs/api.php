<?php
/**
 * Bootstrap file for REST API calls
 *
 * Load and runs the API
 *
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c)2018, Dirk Ollmetzer
 * @package Application
 */

namespace Application;

// include composer packages
include realpath(__DIR__ . '/../vendor/autoload.php');

// load configuration
include __DIR__ . '/../app/config.php';

// set timezone and encoding
date_default_timezone_set(TIMEZONE);
mb_internal_encoding('UTF-8');

// load and run the application
$app = new \dollmetzer\zzaplib\Api($config);
$app->run();