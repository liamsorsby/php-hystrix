<?php

require __DIR__ . '/../../vendor/autoload.php';

use \liamsorsby\Hystrix\Storage\StorageFactory;

$factory = new StorageFactory();
$cb = $factory->create(StorageFactory::APCU, ['threshold' => 3]);
$service = 'test';
do {
    try {
        if ($cb->isOpen($service)) {
            echo "Circuit Breaker Open \n";
            return;
        }
        throw new \Exception("Example Error \n");
    } catch (\Exception $e) {
        echo $e->getMessage();
        $cb->reportFailure($service);
    }
} while (!$cb->isOpen($service));

echo "Circuit Breaker Tripped \n";
