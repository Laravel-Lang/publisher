---
title: Installation
---

# Install Plugins

> [See list](list.md) of official packages working with the translation manager.

For a manager to work, you need to do two things:

1. Install the package into your application. For example, `composer require laravel-lang/lang --dev`.
2. It's all 😊

In order for the manager to successfully process the specified package, its structure must be strictly observed:

```
source/          - The directory must include files with English localization (original).
locales/         - The directory includes a list of folders with localization names.
   <locale>/     - The list of valid names is in the LaravelLang\Publisher\Constants\Locales.
      // files   - Any number of json and php files in the directory.
                   Condition: the file names must match the names from the `source` folder.
```

Now, when the `php artisan lang:update` command is executed, the manager will check the specified packages and automatically update the files in your application.

If files with the same names exist in different packages, for example, `custom.php`, then during their processing all keys from all files will be combined.


> For ease of development, use a ready-made [Translations Template](https://github.com/Laravel-Lang/translations-template).

It's all. Enjoy! 😊
