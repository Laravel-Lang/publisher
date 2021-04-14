[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Using](index.md) / Reset locales

# Reset locales

You can reset the localization files to the default state (cancels all the keys added by the developer regarding the default file).

There are two main launch modes: normal and full.

In `normal` mode, all added keys are reset from the files, except for the settings specified in the `exclude` option.

```bash
php artisan lang:reset *
php artisan lang:reset en de ro zh-CN lv
php artisan lang:reset de
php artisan lang:reset
```

In `full` mode, all files are reset to the default view.

```bash
php artisan lang:reset --full *
php artisan lang:reset --full en de ro zh-CN lv
php artisan lang:reset --full de
php artisan lang:reset --full
```

If you do not specify arguments when passing parameters, then an interactive question will be displayed in the console with a choice of localizations from among the available ones.

```bash
php artisan lang:reset --full
php artisan lang:reset
```

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
