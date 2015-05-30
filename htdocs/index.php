<?php
/**
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2006-2015, Dirk Ollmetzer
 * @package Application
 */

$timeStart = microtime(true);

include '../app/bootstrap.php';

if(DEBUG_PERFORMANCE) {
    $timeEnd = microtime(true);
    echo "\n<!-- execution in ".($timeEnd-$timeStart).' s. with peak memory of '.number_format(memory_get_peak_usage(true), 0, ',', '.').' Bytes -->';
}