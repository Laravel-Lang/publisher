# Add locales

When executing the `php artisan lang:add` command, the list of localizations. Example:

```bash
php artisan lang:add en de ro zh_CN lv
php artisan lang:add de
```

If files do not exist in the destination folder, they will be created. And if the files exist, the console will ask you for a replacement.

If you do not specify arguments when passing parameters, then an interactive question will be displayed in the console with a choice of localizations from among the available ones.

```bash
php artisan lang:add
```
