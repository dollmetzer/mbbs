<?php
/**
 * Bootstrap File
 * 
 * Loads and runs the application
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2006-2015, Dirk Ollmetzer
 * @package Application
 */

namespace Application;

// load configuration
include __DIR__.'/config.php';

// include composer packages
include realpath(__DIR__.'/../vendor/autoload.php');

// set timezone
date_default_timezone_set(TIMEZONE);

// load and run the application
$app = new \dollmetzer\zzaplib\Application($config);
$app->run();
