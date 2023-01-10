# Smart Punctuation

When updating translation keys, you can also enable intelligent converts ASCII quotes, dashes, and ellipses to their Unicode.

For example:

```json
{
    "Some": "\"It's super-configurable... you can even use additional extensions to expand its capabilities -- just like this one!\""
}
```

Will result in files:

```json
{
    "Some": "“It’s super-configurable… you can even use additional extensions to expand its capabilities – just like this one!”"
}
```

This option is enabled in the [configuration file](https://github.com/Laravel-Lang/publisher/blob/main/config/public.php):

```php
'smart_punctuation' => [
    'enable' => true,

    'common' => [
        'double_quote_opener' => '“',
        'double_quote_closer' => '”',
        'single_quote_opener' => '‘',
        'single_quote_closer' => '’',
    ],

    'locales' => [
        Locales::FRENCH->value => [
            'double_quote_opener' => '“',
            'double_quote_closer' => '”',
            'single_quote_opener' => '‘',
            'single_quote_closer' => '’',
        ],

        Locales::UKRAINIAN->value => [
            'double_quote_opener' => '«',
            'double_quote_closer' => '»',
            'single_quote_opener' => '‘',
            'single_quote_closer' => '’',
        ],
    ],
],
```

You can also set different rules for any localization.

By default, conversion is disabled.
