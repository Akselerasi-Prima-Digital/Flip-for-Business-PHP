<?php

require __DIR__ . '../../../vendor/autoload.php';

use AkselerasiPrimaDigital\FlipForBusinessPhp\Config;
use AkselerasiPrimaDigital\FlipForBusinessPhp\FlipForBusiness;

Config::$apiKey = 'YOUR API KEY';
Config::$isProduction = false;

// init client (baseUrl otomatis dari Config)
$flip = new FlipForBusiness();

// Accept Payment — Get All Payment
try {
    $getAllPayment = $flip->acceptPayment()->getAllPayment([
        'start_date' => '2023-01-01',
        'end_date' => '2024-12-12'
        // sesuaikan field dari docs.
    ]);

    print_r($getAllPayment);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
