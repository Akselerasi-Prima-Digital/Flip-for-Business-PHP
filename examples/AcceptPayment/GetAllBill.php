<?php

require __DIR__ . '../../../vendor/autoload.php';

use Reynaldiarya\FlipForBusinessPhp\Config;
use Reynaldiarya\FlipForBusinessPhp\FlipForBusiness;

Config::$apiKey = 'YOUR API KEY';
Config::$isProduction = false;

// init client (baseUrl otomatis dari Config)
$flip = new FlipForBusiness();

// Accept Payment — Get All Bill
try {
    $getAllBill = $flip->acceptPayment()->getAllBill();

    print_r($getAllBill);
} catch (\Throwable $e) {
    echo $e->getMessage(), PHP_EOL, $e->getTraceAsString(), PHP_EOL;
}
