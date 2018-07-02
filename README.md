## Lang Publisher for [caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang) package of Laravel 5.4+

Publisher lang files for the Laravel Framework from caouecs/Laravel-lang.

![lang publisher](https://user-images.githubusercontent.com/10347617/40197727-f26e0aac-5a1c-11e8-81fa-077ad71915d7.png)

<p align="center">
    <a href="https://styleci.io/repos/119022335"><img src="https://styleci.io/repos/119022335/shield" alt="StyleCI" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://img.shields.io/packagist/dt/andrey-helldar/laravel-lang-publisher.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-lang-publisher"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/laravel-lang-publisher/license?format=flat-square" alt="License" /></a>
</p>


## Installation

To get the latest version of Laravel Lang Publisher, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require andrey-helldar/laravel-lang-publisher --dev
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require-dev": {
        "andrey-helldar/laravel-lang-publisher": "^1.0"
    }
}
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in `app/Providers/AppServiceProvider.php`:

```php
public function register()
{
    if($this->app->environment() !== 'production') {
        $this->app->register(\Helldar\LaravelLangPublisher\ServiceProvider::class);
    }
}
```


## How to use

### Important

The package replaces only certain files in your lang directories:

```
auth.php
pagination.php
passwords.php
validation.php
```

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
php artisan lang:install de --force
php artisan lang:install de -f
```

### Update language

When executing the `php artisan lang:update` command, the package learns which localizations are installed in your application and will replace the matching files.

Command `php artisan lang:update` is an alias of `php artisan lang:install --force`.

## Copyright and License

Lang Publisher for [caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang) package was written by Andrey Helldar for the Laravel framework 5.4 or above, and is released under the MIT License. See the [LICENSE](LICENSE) file for details.
