[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Using](index.md) / Remove locales

# Remove locales

> **ATTENTION**
>
> When this command is executed, the entire locale folder with all files is deleted except default and fallback locales.

To delete localizations, you must use `lang:rm` command, passing the letter abbreviations into it:

```bash
php artisan lang:rm de ro zh-CN
```

You can also specify the `*` symbol to delete all localizations:

```bash
php artisan lang:rm *
```

If you do not specify arguments when passing parameters, then an interactive question will be displayed in the console with a choice of localizations from among the available ones.

```bash
php artisan lang:rm
```

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
