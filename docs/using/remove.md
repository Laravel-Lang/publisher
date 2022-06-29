# Remove locales

> **ATTENTION**
>
> When this command is executed, the entire locale folder with all files is deleted except default and fallback locales.

To delete localizations, you must use `lang:rm` command, passing the letter abbreviations into it:

```bash
php artisan lang:rm de ro zh-CN
```

If you do not specify arguments when passing parameters, then an interactive question will be displayed in the console with a choice of localizations from among the available ones.

```bash
php artisan lang:rm
```

By default, the command will return an error message when trying to remove a protected locale.

Protected locales are the set codes in the `locale` and `fallback_locale` parameters of the `config/app.php` file.

To force the deletion of a protected localization, use the `force` option:

```bash
php artisan lang:rm en --force
```
