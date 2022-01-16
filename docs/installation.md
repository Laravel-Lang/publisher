[Laravel Lang Publisher][link_source] / [Main Page](index.md) / Installation

# Installation

> Since version [`11.2`](https://github.com/Laravel-Lang/publisher/releases/tag/v11.2.0), the publisher does not include the mandatory installation of the [`laravel-lang/lang`](https://github.com/Laravel-Lang/lang) package. This is done for the convenience of [developing plugins](using/plugins/index.md) for the publisher. For example, [`laravel‑lang/http‑statuses`](https://github.com/Laravel-Lang/http-statuses).
>
> You can find a list of available plugins [here](using/plugins/extensions.md).

To get the latest version of `Laravel Lang Publisher`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require laravel-lang/publisher laravel-lang/lang --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "laravel-lang/lang": "^10.2",
        "laravel-lang/publisher": "^11.1"
    }
}
```

#### Laravel Framework

You can also publish the config file to change implementations (ie. interface to specific class):

```
php artisan vendor:publish --provider="LaravelLang\Publisher\ServiceProvider"
```

#### Lumen Framework

This package is focused on Laravel development, but it can also be used in Lumen with some workarounds. Because Lumen works a little different, as it is like a barebone version of
Laravel and the main configuration parameters are instead located in `bootstrap/app.php`, some alterations must be made.

You can install Laravel Lang Publisher in `app/Providers/AppServiceProvider.php`, and uncommenting this line that registers the `AppServiceProvider` so it can properly load.

```
// $app->register(App\Providers\AppServiceProvider::class);
```

If you are not using that line, that is usually handy to manage gracefully multiple Lumen installations, you will have to add this line of code under
the `Register Service Providers` section of your `bootstrap/app.php`.

```php
if ($app->environment() !== 'production') {
    $app->register(\LaravelLang\Publisher\ServiceProvider::class);
}
```

## Upgrade from `andrey-helldar/laravel-lang-publisher`

1. Replace `"andrey-helldar/laravel-lang-publisher": "^10.0"` with `"laravel-lang/publisher": "^11.0"` in the `composer.json` file;
2. Replace the `Helldar\LaravelLangPublisher` namespace prefix with `LaravelLang\Publisher` in your application;
3. Remove the `Helldar\PrettyArray\Contracts\Caseable` from `config/lang-publisher.php` file;
4. Remove the `plugins` array key from `config/lang-publisher.php` file;
5. Call the `composer update` console command.

[link_source]:  https://github.com/Laravel-Lang/publisher
