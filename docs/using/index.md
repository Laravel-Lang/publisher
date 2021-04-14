[Laravel Lang Publisher][link_source] / [Main Page](../index.md) / Using

# Using

## Important

The package replaces only certain files in your lang directories:

```
resources/lang/<locale>.json
resources/lang/<locale>/auth.php
resources/lang/<locale>/pagination.php
resources/lang/<locale>/passwords.php
resources/lang/<locale>/validation.phpf
```

If you made changes to these files, they will be saved.

Other files will not be changed in any way during the execution of the actions, except for the execution of the command to delete localizations.


## Table of contents

* [General principles](general-principles.md)
* [Add locales](add.md)
* [Update locales](update.md)
* [Reset locales](reset.md)
* [Remove locales](remove.md)

[link_source]:  https://github.com/andrey-helldar/laravel-lang-publisher
