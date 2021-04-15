[Laravel Lang Publisher][link_source] / [Main Page](../../index.md) / [Features](../index.md) / Packages

# Packages

> Starting with version 9.1, the [Laravel Lang Publisher][link_source] project can work with an unlimited number of packages containing localization files.

For a manager to work, you need to do two things:

1. Install the package into your application. For example, `composer require andrey-helldar/lang-translations --dev`.
2. Specify the namespace of the package in the configuration file of your app:
   > // config/lang-publisher.php
   >
   > ```php
   > <?php
   > 
   > return [
   >     // ...
   > 
   >     'packages' => [
   >         'andrey-helldar/lang-translations',
   >     ],
   > ];
   > ``` 

In order for the manager to successfully process the specified package, its structure must be strictly observed:

```
source/          - The directory must include files with English localization (original).
locales/         - The directory includes a list of folders with localization names.
   <locale>/     - The list of valid names is in the Helldar\LaravelLangPublisher\Constants\Locales.
      // files   - Any number of json and php files in the directory.
                   Condition: the file names must match the names from the `source` folder.
```

Now, when the `php artisan lang:update` command is executed, the manager will check the specified packages and automatically update the files in your application.

If files with the same names exist in different packages, for example, `custom.php`, then during their processing all keys from all files will be combined.

Also, if these files contain matching keys from other packages, the key will eventually be saved with the package specified at the bottom of the list in the `packages` key of the `config/lang-publisher.php` file.

It's all. Enjoy! 😊

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
