<?php
require_once 'src/Quafzi/Service.php';
require_once 'src/Quafzi/Weather.php';
$service = new \Quafzi\Service();
$weather = new \Quafzi\Weather();

echo $weather->fetchData($service)
    ->getSummary() . PHP_EOL;
