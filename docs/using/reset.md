[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Using](index.md) / Reset locales

# Reset locales

You can reset the localization files to the default state.

There are two main launch modes: normal and full.

In `normal` mode, files are updated without taking into account excludes. All keys added by the developer are saved in the project.

```bash
php artisan lang:reset en de ro zh-CN lv
php artisan lang:reset de
php artisan lang:reset
```

In `full` mode, absolutely all unnecessary translation keys will be removed from the file and the files will be restored to their "factory" form.

```bash
php artisan lang:reset --full en de ro zh-CN lv
php artisan lang:reset --full de
php artisan lang:reset --full
```

[link_source]:  https://github.com/Laravel-Lang/publisher
