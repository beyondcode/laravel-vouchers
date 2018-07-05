# Laravel Vouchers (WIP) 🎟

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-vouchers.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-vouchers)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-vouchers/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-vouchers)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-vouchers.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-vouchers)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-vouchers.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-vouchers)

Allow users to redeem vouchers that are bound to models.

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-vouchers
```

## Usage

``` php
$skeleton = new BeyondCode\Vouchers();
echo $skeleton->echoPhrase('Hello, BeyondCode!');
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marcel@beyondco.de instead of using the issue tracker.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
