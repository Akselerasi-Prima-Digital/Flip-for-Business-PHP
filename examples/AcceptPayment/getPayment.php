<?php

require __DIR__ . '../../../vendor/autoload.php';

use AkselerasiPrimaDigital\FlipForBusinessPhp\Config;
use AkselerasiPrimaDigital\FlipForBusinessPhp\FlipForBusiness;

Config::$apiKey = 'YOUR API KEY';
Config::$isProduction = false;

// init client (baseUrl otomatis dari Config)
$flip = new FlipForBusiness();

// Accept Payment — Create Bill
try {
    $getPayment = $flip->acceptPayment()->getPayment(260804, [
        'sort_by' => 'created_at',
        // sesuaikan field dari docs.
    ]);

    print_r($getPayment);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
