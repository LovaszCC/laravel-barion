# Simple Laravel Wrapper for Barion Payment Gateway

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lovaszcc/laravel-barion.svg?style=flat-square)](https://packagist.org/packages/lovaszcc/laravel-barion)

[![Total Downloads](https://img.shields.io/packagist/dt/lovaszcc/laravel-barion.svg?style=flat-square)](https://packagist.org/packages/lovaszcc/laravel-barion)

## Installation

You can install the package via composer:

```bash
composer require lovaszcc/laravel-barion
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="barion-config"
```

This is the contents of the published config file:

```php
return [
    'live_env' => env('BARION_LIVE_ENV', false),
    'pos_key' => env('BARION_POS_KEY'),
    'callback_url' => env('BARION_CALLBACK_URL'),
    'redirect_url' => env('BARION_REDIRECT_URL'),
    'payee' => env('BARION_PAYEE'),
];
```

## Usage

```php
    use LovaszCC\Barion\Enums\Currency;
    use LovaszCC\Barion\Enums\FundingSources;
    use LovaszCC\Barion\Enums\Locale;
    use LovaszCC\Barion\Enums\PaymentType;
    use LovaszCC\Barion\Facades\Barion;

    $transaction_id = 'ORDER-1234567890';
    $items = [
        [
            'Name' => 'Test item',
            'Description' => 'Test item description',
            'UnitPrice' => 1000,
            'Quantity' => 1,
            'Unit' => 'db',
            'ItemTotal' => 1000,
        ],
        [
            'Name' => 'Test item2',
            'Description' => 'Test item description2',
            'UnitPrice' => 1000,
            'Quantity' => 1,
            'Unit' => 'db',
            'ItemTotal' => 1000,
        ],
    ];
    $data = [
        'PaymentType' => PaymentType::IMMEDIATE,
        'GuestCheckOut' => true,
        'FundingSources' => [FundingSources::ALL],
        'Locale' => Locale::HU,
        'Currency' => Currency::HUF,
        'RedirectUrl' => config('barion.redirect_url'),
        'CallbackUrl' => config('barion.callback_url'),
        'Transactions' => [
            [
                'POSTransactionId' => $transaction_id,
                'Payee' => config('barion.payee'),
                'Total' => 2000,
                'Items' => $items,
            ],
        ],
    ];

    // returns array with paymentId and GatewayUrl
    dd(Barion::initPayment($data));
```

## Steps to Use

1. Create a new payment
2. Redirect the user to the GatewayUrl
3. Wait for the callback
4. Get the payment status
5. If the payment is successful, update the order status
6. If the payment is failed, update the order status

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

-   [Lovász Krisztián](https://github.com/LovaszCC)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
