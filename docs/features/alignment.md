[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / [Features](index.md) / Alignment

# Alignment

When updating files, all comments from the final files are automatically deleted. Unfortunately, [var_export](https://www.php.net/manual/en/function.var-export.php) does not know
how to work with comments.

Your file example:

// auth.php

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'failed'   => 'These credentials do not match our records 123456.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'foo'      => 'bar',
];
```

An updated file:

```php
<?php

return [
    'failed'   => 'These credentials do not match our records.',
    'foo'      => 'bar',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
];
```

and example of `validation.php` file:

// your file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    
    // many rules
    
    'uuid'                 => 'The :attribute must be a valid UUID.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'name' => [
            'required' => 'Custom message 1',
            'string'   => 'Custom message 2',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [
        'name' => 'Foo',
        'bar'  => 'Bar',
        'baz'  => 'Baz',
    ],
];
```

Updated:

```php
<?php

return [
    'accepted'   => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    
    // many rules
    
    'uuid'       => 'The :attribute must be a valid UUID.',
    'custom'     => [
        'name' => [
            'required' => 'Custom message 1',
            'string'   => 'Custom message 2',
        ],
    ],
    'attributes' => [
        'bar'        => 'Bar',
        'baz'        => 'Baz',
        'email'      => 'E-Mail address',
        'first_name' => 'First Name',
        'last_name'  => 'Last Name',
        'name'       => 'Name',
        'username'   => 'Nickname',
    ],
];
```

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
