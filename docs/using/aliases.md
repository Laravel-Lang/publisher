# Aliases

If you want to name codes differently, such as `de-DE` instead of `de` or `de-CH` instead of `de_CH`, you can define aliases in
the [`configuration file`](https://github.com/Laravel-Lang/publisher/blob/main/config/public.php).

After that, all adding, updating, and deleting actions will automatically use the specified aliases.

For example, `config/lang-publisher.php` config file:

```php
<?php

use LaravelLang\Publisher\Constants\Locales;

return [
    'aliases' => [
        Locales::GERMAN->value => 'de-DE',

        Locales::GERMAN_SWITZERLAND->value => 'de-CH',
    ],
];
```

```bash
php artisan lang:add de de-CH
```

```
lang
    de-CH
    de-DE
```
