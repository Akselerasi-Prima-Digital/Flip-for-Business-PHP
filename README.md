# Flip for Business PHP Client

Unofficial PHP client for [Flip for Business](https://flip.id/business) APIs. This library helps you integrate Flip's services like Disbursement, Accept Payment, and International Transfer into your PHP application easily.

## Features

- **Accept Payment**: Create bills, get payment status, list payments.
- **Disbursement**: Send money to multiple bank accounts.
- **International Disbursement**: Send money abroad.
- **General**: General API utilities.
- **PSR-4 Autoloading**
- **Guzzle HTTP Client** under the hood.

## Requirements

- PHP >= 8.1
- Composer

## Installation

Clone repository dan install dependencies:

```bash
git clone https://github.com/Akselerasi-Prima-Digital/Flip-for-Business-PHP.git
cd Flip-for-Business-PHP
composer install
```

## Configuration

You need to configure your API Key and environment (Sandbox/Production) before using the client.

```php
use AkselerasiPrimaDigital\FlipForBusinessPhp\Config;

// Set your API Key
Config::$apiKey = 'YOUR_FLIP_API_KEY';

// Set environment (true for Production, false for Sandbox)
Config::$isProduction = false; // Default is false

// Enable debug mode (optional, logs requests/responses to error_log)
Config::$debug = true;
```

## Usage

### Initialization

Initialize the main client after configuration:

```php
use AkselerasiPrimaDigital\FlipForBusinessPhp\FlipForBusiness;

$flip = new FlipForBusiness();
```

### Accept Payment - Create Bill

Here is an example of how to create a bill:

```php
try {
    $response = $flip->acceptPayment()->createBill([
        'title' => 'Invoice #123',
        'type' => 'SINGLE',
        'amount' => 150000,
        'expired_date' => date('Y-m-d H:i', strtotime('+1 day')),
        'redirect_url' => 'https://your-website.com/payment/finish',
        'is_address_required' => 0,
        'sender_name' => 'John Doe',
        'sender_email' => 'john@example.com',
        'sender_phone_number' => '081234567890',
        'step' => 'direct_api' // or other steps as per documentation
    ]);

    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### More Examples

Check the `examples/` directory for more usage examples on different features.

## License

This project is licensed under the [MIT License](LICENSE.md).

## Disclaimer

This library is unofficial and not affiliated with Flip.id. Use it at your own risk.
