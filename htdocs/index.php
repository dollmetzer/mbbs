<?php
$timeStart = microtime(true);

include '../app/bootstrap.php';

if(DEBUG_PERFORMANCE) {
    $timeEnd = microtime(true);
    echo "\n<!-- execution in ".($timeEnd-$timeStart).' s. with peak memory of '.number_format(memory_get_peak_usage(true), 0, ',', '.').' Bytes -->';
}