# General principles

Almost all console commands accept an array of localizations as a parameter.

For example:

```bash
php artisan lang:<command> en de ro
php artisan lang:<command> de
php artisan lang:<command>
```

Where:

* `en de ro` - a list of locales separated by a space;
* `de` - it is also possible to specify a single localization name;
* if the parameter is not passed during the call, the script will ask two questions:
    * `Do you want to %s all localizations?`, when `%s` is `install`, `remove` or `reset`;
    * If `no`, then next question is `Select localizations to add (specify the necessary localizations separated by commas)`.

> When performing any work with files (`install`, `uninstall`, `reset` and `update`), in addition to php files, work with json files, including translation
> for [Laravel Framework](https://laravel.com), [Jetstream](https://jetstream.laravel.com)
> , [Fortify](https://github.com/laravel/fortify), [Cashier](https://laravel.com/docs/billing), [Breeze](https://github.com/laravel/breeze), [Nova](https://nova.laravel.com)
> , [Spark](https://spark.laravel.com) and [UI](https://github.com/laravel/ui), will also be automatically performed.
