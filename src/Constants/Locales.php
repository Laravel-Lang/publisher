<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Constants;

use ArchTech\Enums\Values;

/**
 * Based on ISO 15897.
 *
 * @see https://laravel.com/docs/localization#introduction
 *
 * Unicode standard (Intl)
 * @see https://icu4c-demos.unicode.org/icu-bin/locexp
 *
 * ISO-639-1 standard
 * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */
enum Locales: string
{
    use Values;

    case AFRIKAANS           = 'af';
    case ALBANIAN            = 'sq';
    case ARABIC              = 'ar';
    case ARMENIAN            = 'hy';
    case AZERBAIJANI         = 'az';
    case BASQUE              = 'eu';
    case BELARUSIAN          = 'be';
    case BENGALI             = 'bn';
    case BOSNIAN             = 'bs';
    case BULGARIAN           = 'bg';
    case CATALAN             = 'ca';
    case CENTRAL_KHMER       = 'km';
    case CHINESE             = 'zh_CN';
    case CHINESE_HONG_KONG   = 'zh_HK';
    case CHINESE_T           = 'zh_TW';
    case CROATIAN            = 'hr';
    case CZECH               = 'cs';
    case DANISH              = 'da';
    case DUTCH               = 'nl';
    case ENGLISH             = 'en';
    case ESTONIAN            = 'et';
    case FINNISH             = 'fi';
    case FRENCH              = 'fr';
    case GALICIAN            = 'gl';
    case GEORGIAN            = 'ka';
    case GERMAN              = 'de';
    case GERMAN_SWITZERLAND  = 'de_CH';
    case GREEK               = 'el';
    case GUJARATI            = 'gu';
    case HEBREW              = 'he';
    case HINDI               = 'hi';
    case HUNGARIAN           = 'hu';
    case ICELANDIC           = 'is';
    case INDONESIAN          = 'id';
    case ITALIAN             = 'it';
    case JAPANESE            = 'ja';
    case KANNADA             = 'kn';
    case KAZAKH              = 'kk';
    case KOREAN              = 'ko';
    case LATVIAN             = 'lv';
    case LITHUANIAN          = 'lt';
    case MACEDONIAN          = 'mk';
    case MALAY               = 'ms';
    case MARATHI             = 'mr';
    case MONGOLIAN           = 'mn';
    case NEPALI              = 'ne';
    case NORWEGIAN_BOKMAL    = 'nb';
    case NORWEGIAN_NYNORSK   = 'nn';
    case OCCITAN             = 'oc';
    case PASHTO              = 'ps';
    case PERSIAN             = 'fa';
    case PILIPINO            = 'fil';
    case POLISH              = 'pl';
    case PORTUGUESE          = 'pt';
    case PORTUGUESE_BRAZIL   = 'pt_BR';
    case ROMANIAN            = 'ro';
    case RUSSIAN             = 'ru';
    case SARDINIAN           = 'sc';
    case SERBIAN_CYRILLIC    = 'sr_Cyrl';
    case SERBIAN_LATIN       = 'sr_Latn';
    case SERBIAN_MONTENEGRIN = 'sr_Latn_ME';
    case SINHALA             = 'si';
    case SLOVAK              = 'sk';
    case SLOVENIAN           = 'sl';
    case SPANISH             = 'es';
    case SWAHILI             = 'sw';
    case SWEDISH             = 'sv';
    case TAGALOG             = 'tl';
    case TAJIK               = 'tg';
    case THAI                = 'th';
    case TURKISH             = 'tr';
    case TURKMEN             = 'tk';
    case UIGHUR              = 'ug';
    case UKRAINIAN           = 'uk';
    case URDU                = 'ur';
    case UZBEK_CYRILLIC      = 'uz_Cyrl';
    case UZBEK_LATIN         = 'uz_Latn';
    case VIETNAMESE          = 'vi';
    case WELSH               = 'cy';
}
