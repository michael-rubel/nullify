![Convert empty data of any type to null](https://user-images.githubusercontent.com/37669560/204819769-a4cf19ef-dec2-438a-aed7-b485206cb8e6.png)

# Nullify
[![Latest Version on Packagist](https://img.shields.io/packagist/v/michael-rubel/nullify.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/nullify)
[![Total Downloads](https://img.shields.io/packagist/dt/michael-rubel/nullify.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/nullify)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/michael-rubel/nullify.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/nullify/?branch=main)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/michael-rubel/nullify.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/nullify/?branch=main)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michael-rubel/nullify/run-tests/main?style=flat-square&label=tests&logo=github)](https://github.com/michael-rubel/nullify/actions)
[![PHPStan](https://img.shields.io/github/workflow/status/michael-rubel/nullify/phpstan/main?style=flat-square&label=phpstan&logo=laravel)](https://github.com/michael-rubel/nullify/actions)

A plain PHP class to convert empty data of any type to `null`.

PHP `^8.0` is required to use this class.

## Installation

```bash
composer require michael-rubel/nullify
```

## Usage

```php
use MichaelRubel\Nullify\Nullify;

Nullify::the($value);
```

## Testing
```bash
composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
