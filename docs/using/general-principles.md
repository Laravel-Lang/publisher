[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Using](index.md) / General principles

# General principles

All commands have common key types:

* `--force` (also `-f`) - runs a command to force execution (works on all except the `lang:reset` command).

Parameters on call (used in all except the `lang:update` command):

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

> When performing any work with files (`install`, `uninstall`, `reset` and `update`), in addition to php files, work with json files, including translation for [Laravel Framework][link_laravel], [Laravel Jetstream][link_jetstream], [Laravel Fortify][link_fortify]
, [Laravel Cashier][link_cashier] and [Laravel Nova][link_nova], will also be automatically performed.


[link_cashier]:     https://laravel.com/docs/8.x/billing

[link_fortify]:     https://github.com/laravel/fortify

[link_jetstream]:   https://jetstream.laravel.com

[link_laravel]:     https://laravel.com

[link_nova]:        https://nova.laravel.com

[link_source]:      https://github.com/andrey-helldar/laravel-lang-publisher
