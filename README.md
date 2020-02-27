## Lang Publisher for [caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang) package of Laravel 5.3+

Publisher lang files for the Laravel Framework from caouecs/Laravel-lang.

![lang publisher](https://user-images.githubusercontent.com/10347617/40197727-f26e0aac-5a1c-11e8-81fa-077ad71915d7.png)

<p align="center">
    <a href="https://styleci.io/repos/119022335"><img src="https://styleci.io/repos/119022335/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://img.shields.io/packagist/dt/andrey-helldar/laravel-lang-publisher.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/license?format=flat-square" alt="License" /></a>
</p>


## Contents

* [Installation](#installation)
  * [Compatibility table](#compatibility-table)
* [How to use](#how-to-use)
  * [Important](#important)
  * [Install language](#install-language)
  * [Update language](#update-language)
  * [Features](#features)
* [Copyright and License](#copyright-and-license)


## Attention

Version `^3.0` is under development.

Stable package version - `^2.0`.


## Installation

To get the latest version of Laravel Lang Publisher, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/laravel-lang-publisher --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "andrey-helldar/laravel-lang-publisher": "^3.0"
    }
}
```

You can also publish the config file to change implementations (ie. interface to specific class):
```
php artisan vendor:publish --provider="Helldar\LaravelLangPublisher\ServiceProvider"
```


#### Compatibility table

|Laravel version|PHP min version|PHP tested version|Recommended|Package min version|Package max version|Comment|
|---|---|---|---|---|---|---|
|5.3|^5.6.4|5.6|^1.0|1.1.2|1.1.4|---|
|5.4|^5.6.4|5.6|^1.0|1.0.0|1.1.4|---|
|5.5|^7.0.0|7.1, 7.2, 7.3|^1.0|1.0.0|1.6.0|---|
|5.6|^7.1.3|7.2, 7.3|^1.0|1.0.0|1.6.0|---|
|5.7, 5.8|^7.1.3|7.2, 7.3|^1.0|1.0.0|1.6.0|You can install package `^1.0` version on the Laravel 5.8, but there are two nuances: translation files from version 5.7 will be copied, and there will be no support for [saving validator keys](https://github.com/andrey-helldar/laravel-lang-publisher#features).|
|5.8, 6.x, 7.x|^7.1.3|7.1, 7.2, 7.3, 7.4|^2.0|2.0.0|2.3.1|---|
|6.x, 7.x|^7.2.5|7.2, 7.3, 7.4|^3.0|3.0.0|^3.0|Is under development.|


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


### Install language

When executing the `php artisan lang:install` command, the list of localizations. Example:

```bash
php artisan lang:install en de ro zh-CN lv
php artisan lang:install de
```

If files do not exist in the destination folder, they will be created. And if the files exist, the console will ask you for a replacement.

Also, if the files exist and you do not want to agree each time, you can pass the attribute `--force` or its alias `-f` for forced replacement.

```bash
php artisan lang:install de en ro zh-CN --force
php artisan lang:install de --force
php artisan lang:install de -f
```

### Update language

When executing the `php artisan lang:update` command, the package learns which localizations are installed in your application and will replace the matching files.

Command `php artisan lang:update` is an alias of `php artisan lang:install --force`.


### Features

**Attention!**  This feature works only in Laravel 5.5 and higher with php 7.1.3 and higher.

When updating files, all comments from the final files are automatically deleted. Unfortunately, [var_export](https://www.php.net/manual/en/function.var-export.php) does not know how to work with comments.

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

Updated file:
```php
// auth.php
<?php

return [
    'failed'   => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'foo'      => 'bar',
];
```

And example of `validation.php` file:
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


## Copyright and License

`Lang Publisher` for [caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang) package was written by Andrey Helldar for the Laravel framework 5.3 or above, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
