# Akurateco API Client

## Table of contents
* [General info](#general-info)
* [Requirements](#requirements)
* [Composer Installation](#composer-installation)
* [Getting started](#getting-started)

## General info
Library for interacting with an external API.

## Requirements
Get yourself a free `Akurateco` account. No sign up costs.

PHP >= 7.4

## Composer Installation
By far the easiest way to install is to require it with Composer.
```
composer require dimaveresklia/akurateco:^1.0

{
    "require": {
        "dimaveresklia/akurateco": "^1.0"
    }
}
```

## Getting started
Initializing the Akurateco API client, and setting your Public Key and Clie key.

```
$akurateco = new Dimaveresklia\Akurateco\AkuratecoApiClient();
$akurateco->setKeys(
    '5b6492f0-f8f5-11ea-976a-0242c0a85007',
    'd0ec0beca8a3c30652746925d5380cf3'
);
```

Create a `SALE` transaction.
```
    $data = [
        "action" => "SALE",
        "client_key" => "c2b8fb04-110f-11ea-bcd3-0242c0a85004",
        "order_id" => "ORDER-12345",
        "order_amount" => "1.99",
        "order_currency" => "USD",
        "order_description" => "Product",
        "card_number" => "4111111111111111",
        "card_exp_month" => "01",
        "card_exp_year" => "2025",
        "card_cvv2" => "000",
        "payer_first_name" => "John",
        "payer_last_name" => "Doe",
        "payer_address" => "Big street",
        "payer_country" => "US",
        "payer_state" => "CA",
        "payer_city" => "City",
        "payer_zip" => "123456",
        "payer_email" => "doe@example.com",
        "payer_phone" => "199999999",
        "payer_ip" => "123.123.123.123",
        "term_url_3ds" => "http://client.site.com/return.php",
    ];
    $saleResponse = $akurateco->sale->create($data);
```

Check the transaction status.

```
$saleResponse->status; 
```