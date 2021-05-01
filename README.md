# cmcap-api
[![Build Status](https://travis-ci.com/r3bers/cmcap-api.svg?branch=master)](https://travis-ci.com/r3bers/cmcap-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/r3bers/cmcap-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/r3bers/cmcap-api/?branch=master)
[![Test Coverage](https://api.codeclimate.com/v1/badges/e82ddd9ab3f2c47beb16/test_coverage)](https://codeclimate.com/github/r3bers/cmcap-api/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/e82ddd9ab3f2c47beb16/maintainability)](https://codeclimate.com/github/r3bers/cmcap-api/maintainability)
[![GitHub license](https://img.shields.io/github/license/r3bers/cmcap-api)](https://github.com/r3bers/cmcap-api/blob/master/LICENSE)
![Packagist](https://img.shields.io/packagist/dt/r3bers/cmcap-api)

A simple PHP wrapper for [CoinMarketCap API v1](https://coinmarketcap.com/api/documentation/v1).

## Requirements

* PHP >= 7.3
* ext-json
* [CoinMarketCap account](https://pro.coinmarketcap.com/login/), API Key

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require r3bers/cmcap-api
```
or add

```json
"r3bers/cmcap-api" : "^1.0"
```

to require the section of your application's `composer.json` file.

## Basic usage

### Example

```php
use R3bers\CMCapApi\CMCapClient;

$client = new CMCapClient();
$client->setCredential('API_KEY');

$data = $client->cryptocurrency()->map();

```
## Available methods

## Further Information
Please, check the [CoinMarketCap site](https://coinmarketcap.com/api/documentation/v1) documentation for further information about API.

## License

`r3bers/cmcap-api` is released under the MIT License. See the bundled [LICENSE](./LICENSE) for details.
