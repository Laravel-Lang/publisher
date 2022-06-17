---
title: Installation
---

# Install Plugins

> [See list](local.md) of official packages working with the translation manager.

For a manager to work, you need to do two things:

1. Install the package into your application. For example, `composer require laravel-lang/lang --dev`.
2. It's all 😊

Now, when the `php artisan lang:update` command is executed, the manager will check the specified packages and automatically update the files in your application.

If files with the same names exist in different packages, for example, `custom.php`, then during their processing all keys from all files will be combined.


> For ease of development, use a ready-made [Translations Template](https://github.com/Laravel-Lang/translations-template).

It's all. Enjoy! 😊
