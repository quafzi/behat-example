<?php
require_once 'src/Quafzi/Service.php';
require_once 'src/Quafzi/Weather.php';
$service = new \Quafzi\Service();
$weather = new \Quafzi\Weather();

try {
    echo $weather->fetchData($service)
        ->getSummary() . PHP_EOL;
} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
