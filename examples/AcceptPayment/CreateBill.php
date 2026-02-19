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
    $createBill = $flip->acceptPayment()->createBill([
        'title' => 'Coffee Table',
        'type' => 'SINGLE',
        'amount' => 900000,
        'expired_date' => '2025-12-30 15:50',
        'redirect_url' => 'https://someurl.com',
        'step' => 'direct_api'
        // sesuaikan field dari docs.
    ]);

    print_r($createBill);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
