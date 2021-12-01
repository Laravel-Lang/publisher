[Laravel Lang Publisher][link_source] / [Main Page](index.md) / Compatibility

# Compatibility

|Laravel, Lumen|PHP tested|Package Tag|Comment|
|---|---|---|---|
|7.x, 8.x|7.3, 7.4, 8.0, 8.1|^11.0| ![Supported][badge_supported] [changelog 11.x](changelog.md#11.x) (**Important!**) Namespace changed. Replaced packages.  |
|7.x, 8.x|7.3, 7.4, 8.0, 8.1|^10.0| ![Supported][badge_not_supported] [changelog 10.x](changelog.md#10.x)  |
|7.x, 8.x|7.3, 7.4, 8.0, 8.1|^9.0| ![Subscribers][badge_not_supported] [changelog 9.x](changelog.md#9.x)  |
|7.x, 8.x|7.2, 7.3, 7.4, 8.0, 8.1|^8.0| ![Subscribers][badge_not_supported] Uses packages `andrey-helldar/support` and `andrey-helldar/pretty-array` version `^2.0` |
|7.x, 8.x|7.2, 7.3, 7.4, 8.0, 8.1|^7.0|  ![Subscribers][badge_not_supported] [PHP Intl version](https://github.com/Laravel-Lang/lang/releases/tag/8.0.0), Uses packages `andrey-helldar/support` and `andrey-helldar/pretty-array` version `^1.0` |
|7.x, 8.x|7.2, 7.3, 7.4|^6.0| ![Subscribers][badge_not_supported] Laravel [Jetstream](https://jetstream.laravel.com) and [Fortify](https://github.com/laravel/fortify) supported |
|7.x, 8.x|7.2, 7.3, 7.4|^5.0| ![Not Supported][badge_not_supported] Changed localization names in accordance with the ISO 15897 standard (see [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang/issues/1286) and [official docs](https://laravel.com/docs/7.x/localization#introduction).|
|7.x, 8.x|7.2, 7.3, 7.4|^4.0| ![Not Supported][badge_not_supported] Support will end on September 3, 2020. If you installed the package before the release of version 4.0.1, To fix config cache errors on production, update the `case` key value in [config/lang-publisher.php](config/lang-publisher.php) file.|
|6.x, 7.x|7.2, 7.3, 7.4|^3.0| ![Not Supported][badge_not_supported] |
|5.8, 6.x, 7.x|7.2, 7.3, 7.4|^2.0| ![Not Supported][badge_not_supported] |
|5.7, 5.8|7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] You can install package `^1.0` version on the Laravel 5.8, but there are two nuances: translation files from version 5.7 will be copied, and there will be no support for [saving validator keys](https://github.com/Laravel-Lang/publisher#features). |
|5.6|7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] |
|5.5|7.1, 7.2, 7.3|^1.0| ![Not Supported][badge_not_supported] |
|5.4|5.6|^1.0| ![Not Supported][badge_not_supported] |
|5.3|5.6|^1.0| ![Not Supported][badge_not_supported] |

[badge_not_supported]:          https://img.shields.io/badge/not%20supported-lightgrey?style=flat-square

[badge_supported]:              https://img.shields.io/badge/supported-green?style=flat-square

[link_source]:                  https://github.com/Laravel-Lang/publisher
