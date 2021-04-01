# Lang Publisher

Publisher lang files for the [Laravel Framework][link_laravel], [Laravel Jetstream][link_jetstream], [Laravel Fortify][link_fortify]
, [Laravel Cashier][link_cashier] and [Laravel Nova][link_nova] from [Laravel-Lang/lang][link_source] package.

![lang publisher](https://user-images.githubusercontent.com/10347617/40197727-f26e0aac-5a1c-11e8-81fa-077ad71915d7.png)

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

[![StyleCI Status][badge_styleci]][link_styleci]
[![Github Workflow Status][badge_build]][link_build]
[![Coverage Status][badge_coverage]][link_scrutinizer]
[![Scrutinizer Code Quality][badge_quality]][link_scrutinizer]


## Installation

To get the latest version of Laravel Lang Publisher, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/laravel-lang-publisher --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "andrey-helldar/laravel-lang-publisher": "^8.0"
    }
}
```

#### Laravel Framework

You can also publish the config file to change implementations (ie. interface to specific class):

```
php artisan vendor:publish --provider="Helldar\LaravelLangPublisher\ServiceProvider"
```

#### Laravel Jetstream

The translation file for Laravel Jetstream is merged with the Laravel translation json file.

Use the `--json` or `--jet` parameter to install.

For example:

```
php artisan lang:install --json en de ro zh-CN lv
php artisan lang:install --json de

php artisan lang:install --jet en de ro zh-CN lv
php artisan lang:install --jet de
```

> `--jet` is an alias for `--json`.

#### Laravel Fortify

The translation file for Laravel Fortify is merged with the Laravel translation json file.

Use the `--json` or `--fortify` parameter to install.

For example:

```
php artisan lang:install --json en de ro zh-CN lv
php artisan lang:install --json de

php artisan lang:install --fortify en de ro zh-CN lv
php artisan lang:install --fortify de
```

> `--fortify` is an alias for `--json`.

#### Laravel Cashier

The translation file for Laravel Cashier is merged with the Laravel translation json file.

Use the `--json` or `--cash` parameter to install.

For example:

```
php artisan lang:install --json en de ro zh-CN lv
php artisan lang:install --json de

php artisan lang:install --cashier en de ro zh-CN lv
php artisan lang:install --cashier de
```

> `--cashier` is an alias for `--json`.

#### Laravel Nova

The translation file for Laravel Nova is merged with the Laravel translation json file.

Use the `--json` or `--nova` parameter to install.

For example:

```
php artisan lang:install --json en de ro zh-CN lv
php artisan lang:install --json de

php artisan lang:install --nova en de ro zh-CN lv
php artisan lang:install --nova de
```

> `--nova` is an alias for `--json`.

#### Lumen Framework

This package is focused on Laravel development, but it can also be used in Lumen with some workarounds. Because Lumen works a little different, as it is like a
barebone version of Laravel and the main configuration parameters are instead located in `bootstrap/app.php`, some alterations must be made.

You can install Laravel Lang Publisher in `app/Providers/AppServiceProvider.php`, and uncommenting this line that registers the App Service Providers so it can
properly load.

```
// $app->register(App\Providers\AppServiceProvider::class);
```

If you are not using that line, that is usually handy to manage gracefully multiple Lumen installations, you will have to add this line of code under
the `Register Service Providers` section of your `bootstrap/app.php`.

```php
if ($app->environment() !== 'production') {
    $app->register(\Helldar\LaravelLangPublisher\ServiceProvider::class);
}
```

### Compatibility table

|Laravel/Lumen version|PHP tested version|Package Tag|Comment|
|---|---|---|---|
|7.x, 8.x|7.2, 7.3, 7.4, 8.0|^8.0| ![Supported][badge_supported] Uses packages `andrey-helldar/support` and `andrey-helldar/pretty-array` version `^2.0` |
|7.x, 8.x|7.2, 7.3, 7.4, 8.0|^7.0| ![Not Supported][badge_not_supported] [PHP Intl version](https://github.com/Laravel-Lang/lang/releases/tag/8.0.0), Uses packages `andrey-helldar/support` and `andrey-helldar/pretty-array` version `^1.0` |
|7.x, 8.x|7.2, 7.3, 7.4|^6.0| ![Not Supported][badge_not_supported] Laravel [Jetstream](https://jetstream.laravel.com) and [Fortify](https://github.com/laravel/fortify) supported |
|7.x, 8.x|7.2, 7.3, 7.4|^5.0| ![Not Supported][badge_not_supported] Changed localization names in accordance with the ISO 15897 standard (see [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang/issues/1286) and [official docs](https://laravel.com/docs/7.x/localization#introduction).|
|7.x, 8.x|7.2, 7.3, 7.4|^4.0| ![Not Supported][badge_not_supported] Support will end on September 3, 2020. If you installed the package before the release of version 4.0.1, To fix config cache errors on production, update the `case` key value in [config/lang-publisher.php](config/lang-publisher.php) file.|
|6.x, 7.x|7.2, 7.3, 7.4|^3.0| ![Not Supported][badge_not_supported] |
|5.8, 6.x, 7.x|7.2, 7.3, 7.4|^2.0| ![Not Supported][badge_not_supported] |
|5.7, 5.8|7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] You can install package `^1.0` version on the Laravel 5.8, but there are two nuances: translation files from version 5.7 will be copied, and there will be no support for [saving validator keys](https://github.com/andrey-helldar/laravel-lang-publisher#features). |
|5.6|7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] |
|5.5|7.1, 7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] |
|5.4|5.6|^1.0| ![Not Supported][badge_not_supported] |
|5.3|5.6|^1.0| ![Not Supported][badge_not_supported] |

## How to use

### Important

The package replaces only certain files in your lang directories:

```
auth.php
pagination.php
passwords.php
validation.php
```

**If you made changes to the files, they will be saved.**

He does not touch any other files.


#### General principles

All commands have common key types:

* `--json` (also `-j`) - runs a command to work with translation JSON files. Available aliases: `--jet`, `--fortify`, `--cashier` and `--nova`;
* `--force` (also `-f`) - runs a command to force execution (works on all but the `reset` command).

Parameters on call (used in all except `update`):

```bash
php artisan lang:<command> en de ro
php artisan lang:<command> de
php artisan lang:<command> *
php artisan lang:<command>
```

Where:

* `en de ro` - a list of locales separated by a space;
* `de` - it is also possible to specify a single localization name;
* `*` - when transmitting the asterisk symbol, the action will be performed for all locales
* if the parameter is not passed during the call, the script will ask two questions:
    * `Do you want to %s all localizations?`, when `%s` is `install`, `uninstall` or `reset`;
    * If `no`, then next question is `What languages to %s? (specify the necessary localizations separated by commas)`.

### Install locales

When executing the `php artisan lang:install` command, the list of localizations. Example:

```bash
php artisan lang:install en de ro zh-CN lv
php artisan lang:install de

php artisan lang:install --json en de ro zh-CN lv
php artisan lang:install --json de
```

If files do not exist in the destination folder, they will be created. And if the files exist, the console will ask you for a replacement.

Also, if the files exist, and you do not want to agree each time, you can pass the attribute `--force` or its alias `-f` for forced replacement.

```bash
php artisan lang:install de en ro zh-CN --force
php artisan lang:install de --force
php artisan lang:install de -f

php artisan lang:install --json de en ro zh-CN --force
php artisan lang:install --json de --force
php artisan lang:install --json de -f
```

You can also use the `*` symbol to install all localizations:

```bash
php artisan lang:install * -f
php artisan lang:install * --force
php artisan lang:install * -f

php artisan lang:install --json * -f
php artisan lang:install --json * --force
php artisan lang:install --json * -f
```

### Update locales

When executing the `php artisan lang:update` command, the package learns which localizations installed in your application and will replace the matching files.

Command `php artisan lang:update` is an alias of `php artisan lang:install --force <locales>`.

Also for updating files you can pass the `--json` key:

```bash
php artisan lang:update --json
```

### Uninstall locales

> **ATTENTION**
>
> When this command is executed, the entire locale folder with all files is deleted.

To delete localizations, you must use `lang:uninstall` command, passing the letter abbreviations into it:

```bash
php artisan lang:uninstall de ro zh-CN

php artisan lang:uninstall --json de ro zh-CN
```

You can also specify the `*` symbol to delete all localizations:

```bash
php artisan lang:uninstall *

php artisan lang:uninstall * --json
```

In this case, everything will be deleted, except the default and fallback application locales.


### Reset locales

You can reset the localization files to the default state (cancels all the keys added by the developer regarding the default file).

There are two main launch modes: normal and full.

In `normal` mode, all added keys are reset from the files, except for the settings specified in the `exclude` option.

In `full` mode, all files are reset to the default view.

```bash
php artisan lang:reset *
php artisan lang:reset en de ro zh-CN lv
php artisan lang:reset de
php artisan lang:reset

php artisan lang:reset --json *
php artisan lang:reset --json en de ro zh-CN lv
php artisan lang:reset --json de
php artisan lang:reset --json

php artisan lang:reset --full *
php artisan lang:reset --full en de ro zh-CN lv
php artisan lang:reset --full de
php artisan lang:reset --full 

php artisan lang:reset --full --json *
php artisan lang:reset --full --json en de ro zh-CN lv
php artisan lang:reset --full --json de
php artisan lang:reset --full --json
```

## Features

### Alignment

When updating files, all comments from the final files are automatically deleted.
Unfortunately, [var_export](https://www.php.net/manual/en/function.var-export.php) does not know how to work with comments.

Your file example:

```php
// auth.php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'failed'   => 'These credentials do not match our records 123456.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'foo'      => 'bar',
];
```

An updated file:

```php
// auth.php
<?php

return [
    'failed'   => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'foo'      => 'bar',
];
```

and example of `validation.php` file:
Your file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    
    // many rules
    
    'uuid'                 => 'The :attribute must be a valid UUID.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'name' => [
            'required' => 'Custom message 1',
            'string'   => 'Custom message 2',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [
        'name' => 'Foo',
        'bar'  => 'Bar',
        'baz'  => 'Baz',
    ],
];
```

Updated:

```php
<?php

return [
    'accepted'   => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    
    // many rules
    
    'uuid'       => 'The :attribute must be a valid UUID.',
    'custom'     => [
        'name' => [
            'required' => 'Custom message 1',
            'string'   => 'Custom message 2',
        ],
    ],
    'attributes' => [
        'name'       => 'Name',
        'username'   => 'Nickname',
        'email'      => 'E-Mail address',
        'first_name' => 'First Name',
        'last_name'  => 'Last Name',
        'bar'        => 'Bar',
        'baz'        => 'Baz',
    ],
];
```

### Facades

Perhaps the facades will be useful to you:

#### Config

```php
use Helldar\LaravelLangPublisher\Facades\Config;


// Getting the default localization name.
Config::getLocale(): string


// Getting the fallback localization name.
Config::getFallbackLocale(): string
```

#### Locale

```php
use Helldar\LaravelLangPublisher\Facades\Locale;

// List of available locations.
Locale::available(): array

// List of installed locations.
Locale::installed(bool $is_json = false): array

// Retrieving a list of protected locales.
Locale::protects(): array

// Checks if a language pack is installed.
Locale::isAvailable(string $locale): bool

// Checks whether it is possible to install the language pack.
Locale::isInstalled(string $locale, bool $is_json = false): bool

// The checked locale protecting.
Locale::isProtected(string $locale): bool

// Getting the default localization name.
Locale::getDefault(): string

// Getting the fallback localization name.
Locale::getFallback(): string
```

[badge_build]:          https://img.shields.io/github/workflow/status/andrey-helldar/laravel-lang-publisher/phpunit?style=flat-square

[badge_coverage]:       https://img.shields.io/scrutinizer/coverage/g/andrey-helldar/laravel-lang-publisher.svg?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/laravel-lang-publisher.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/laravel-lang-publisher.svg?style=flat-square

[badge_quality]:        https://img.shields.io/scrutinizer/g/andrey-helldar/laravel-lang-publisher.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/laravel-lang-publisher?label=stable&style=flat-square

[badge_styleci]:        https://styleci.io/repos/119022335/shield

[badge_supported]:      https://img.shields.io/badge/supported-green?style=flat-square

[badge_not_supported]:  https://img.shields.io/badge/not%20supported-lightgrey?style=flat-square

[badge_coming_soon]:    https://img.shields.io/badge/coming%20soon-blue?style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/andrey-helldar/laravel-lang-publisher/actions

[link_cashier]:         https://laravel.com/docs/8.x/billing

[link_fortify]:         https://github.com/laravel/fortify

[link_jetstream]:       https://jetstream.laravel.com

[link_laravel]:         https://laravel.com

[link_license]:         LICENSE

[link_nova]:            https://nova.laravel.com

[link_packagist]:       https://packagist.org/packages/andrey-helldar/laravel-lang-publisher

[link_scrutinizer]:     https://scrutinizer-ci.com/g/andrey-helldar/laravel-lang-publisher/?branch=main

[link_source]:          https://github.com/Laravel-Lang/lang

[link_styleci]:         https://github.styleci.io/repos/119022335
