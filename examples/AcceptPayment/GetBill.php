<?php

require __DIR__ . '../../../vendor/autoload.php';

use AkselerasiPrimaDigital\FlipForBusinessPhp\Config;
use AkselerasiPrimaDigital\FlipForBusinessPhp\FlipForBusiness;

Config::$apiKey = 'YOUR API KEY';
Config::$isProduction = false;

// init client (baseUrl otomatis dari Config)
$flip = new FlipForBusiness();

// Accept Payment — Get Bill
try {
    $getBill = $flip->acceptPayment()->getBill('260804');

    print_r($getBill);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
