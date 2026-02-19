<?php

require __DIR__ . '../../../vendor/autoload.php';

use AkselerasiPrimaDigital\FlipForBusinessPhp\Config;
use AkselerasiPrimaDigital\FlipForBusinessPhp\FlipForBusiness;

Config::$apiKey = 'YOUR API KEY';
Config::$isProduction = false;

// init client (baseUrl otomatis dari Config)
$flip = new FlipForBusiness();

// Accept Payment — Edit Bill
try {
    $editBill = $flip->acceptPayment()->editBill('260795', [
        'title' => 'Coffee Table',
        'type' => 'SINGLE',
        'amount' => 900000,
        'redirect_url' => 'https://someurl.com',
        'status' => 'INACTIVE',
        // sesuaikan field dari docs.
    ]);

    print_r($editBill);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
