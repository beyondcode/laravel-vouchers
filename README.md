# Laravel Vouchers 🎟

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-vouchers.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-vouchers)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-vouchers/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-vouchers)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-vouchers.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-vouchers)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-vouchers.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-vouchers)

This package can associate vouchers with your Eloquent models. This might come in handy, if you need to associate voucher codes with content that is stored in your Eloquent models.

Here is an example of how you can create vouchers and redeem them:

```php
$videoCourse = VideoCourse::find(1);
$voucher = $videoCourse->createVoucher();

auth()->user()->redeemVoucher($voucher);
```

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-vouchers
```

The package will automatically register itself.

You can publish the migration with:

```bash
php artisan vendor:publish --provider="BeyondCode\Vouchers\VouchersServiceProvider" --tag="migrations"
```

After the migration has been published you can create the vouchers table by running the migrations:

```bash
php artisan migrate
```

You can publish the config-file with:

```bash
php artisan vendor:publish --provider=BeyondCode\Vouchers\VouchersServiceProvider --tag="config"
```

This is the contents of the published config file:

```php
<?php

return [

    /*
     * Database table name that will be used in migration
     */
    'table' => 'vouchers',

    /*
     * Database pivot table name for vouchers and users relation
     */
    'relation_table' => 'user_voucher',

    /*
     * List of characters that will be used for voucher code generation.
     */
    'characters' => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',

    /*
     * Voucher code prefix.
     *
     * Example: foo
     * Generated Code: foo-AGXF-1NH8
     */
    'prefix' => null,

    /*
     * Voucher code suffix.
     *
     * Example: foo
     * Generated Code: AGXF-1NH8-foo
     */
    'suffix' => null,

    /*
     * Code mask.
     * All asterisks will be removed by random characters.
     */
    'mask' => '****-****',

    /*
     * Separator to be used between prefix, code and suffix.
     */
    'separator' => '-',

    /*
     * The user model that belongs to vouchers.
     */
    'user_model' => \App\User::class,
];
```

## Usage

The basic concept of this package is that you can create vouchers, that are associated with a specific model. For example, you could have an application that sells online video courses and a voucher would give a user access to one specific video course.

Add the `BeyondCode\Vouchers\Traits\HasVouchers` trait to all your Eloquent models, that you want to be associated with vouchers.

In addition, add the `BeyondCode\Vouchers\Traits\CanRedeemVouchers` trait to your user model. This way users can easily redeem voucher codes and the package takes care of storing the voucher/user association in the database.

## Creating Vouchers

### Using the facade

You can create one or multiple vouchers by using the `Vouchers` facade:

```php
$videoCourse = VideoCourse::find(1);

// Create 5 vouchers associated to the videoCourse model.
$vouchers = Vouchers::create($videoCourse, 5);
```

The return value is an array containing all generated `Voucher` models. 

The Voucher model has a property `code` which contains the generated voucher code.

### Using the Eloquent model

In addition, you can also create vouchers by using the `createVouchers` method on the associated model:

```php
$videoCourse = VideoCourse::find(1);

// Returns an array of Vouchers
$vouchers = $videoCourse->createVouchers(2);

// Returns a single Voucher model instance
$vouchers = $videoCourse->createVoucher();
```

### Vouchers with additional data

It might be useful to associate arbitrary data to your vouchers - maybe a personal message from the person that created the voucher, etc.
When creating the vouchers, you can pass an array as the second argument, which you can then retrieve later on the Voucher instance.

```php
$videoCourse = VideoCourse::find(1);

$vouchers = $videoCourse->createVouchers(2, [
    'from' => 'Marcel',
    'message' => 'This one is for you. I hope you like it'
]);

$voucher = $user->redeem('ABC-DEF');
$from = $voucher->data->get('from');
$message = $voucher->data->get('message');
```

### Vouchers with expiry dates

You can also create vouchers that will only be available until a certain date. A user can not redeem this code afterwards.
The `createVouchers` method accept a Carbon instance as a third parameter.

```php
$videoCourse = VideoCourse::find(1);

$videoCourse->createVouchers(2, [], today()->addDays(7));
```

## Redeeming Vouchers

The easiest way to let your users redeem voucher codes is by using the `redeemCode` method on your User model:

```php
$voucher = $user->redeemCode('ABCD-EFGH');
```

If the voucher is valid, the method will return the voucher model associated with this code.

In case you want to redeem an existing Voucher model, you can use the `redeemVoucher` method on your User model:

```php
$user->redeemVoucher($voucher);
``` 

After a user successfully redeemed a voucher, this package will fire a `BeyondCode\Vouchers\Events\VoucherRedeemed` event. The event contains the user instance and the voucher instance.
You should listen to this event in order to perform the business logic of your application, when a user redeems a voucher.

### Accessing the vouchers associated model

The `Voucher` model has a `model` relation, that will point to the associated Eloquent model:

```php
$voucher = $user->redeemCode('ABCD-EFGH');

$videoCourse = $voucher->model;
``` 

## Handling Errors

The `redeemCode` and `redeemVoucher` methods throw a couple of exceptions that you will want to catch and react to in your application:

### Voucher invalid

If a user tries to redeem an invalid code, the package will throw the following exception: `BeyondCode\Vouchers\Exceptions\VoucherIsInvalid`.

### Voucher already redeemed

All generated vouchers can only be redeemed once. If a user tries to redeem a voucher for a second time, or if another user already redeemed this voucher, the package will throw the following exception: `BeyondCode\Vouchers\Exceptions\VoucherAlreadyRedeemed::class`.

### Voucher expired

If a user tries to redeem an expired voucher code, the package will throw the following exception: `BeyondCode\Vouchers\Exceptions\VoucherExpired`.


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

This package is heavily based on the Laravel Promocodes package from [Zura Gabievi](https://github.com/zgabievi). You can find the code on [GitHub](https://github.com/zgabievi/laravel-promocodes).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
