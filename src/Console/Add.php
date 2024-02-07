<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use LaravelLang\LocaleList\Locale;
use LaravelLang\Locales\Facades\Locales;
use LaravelLang\Publisher\Exceptions\UnknownLocaleCodeException;
use LaravelLang\Publisher\Processors\Add as AddProcessor;
use LaravelLang\Publisher\Processors\Processor;

class Add extends Base
{
    protected $signature = 'lang:add {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Install new localizations.';

    protected ?string $question = 'Do you want to install all localizations?';

    protected Processor|string $processor = AddProcessor::class;

    protected function locales(): array
    {
        if ($this->confirmAll()) {
            return Locales::raw()->available();
        }

        return $this->getLocalesArgument()
            ->each(function (Locale|string $locale) {
                if (! Locales::isAvailable($locale)) {
                    throw new UnknownLocaleCodeException($locale);
                }
            })
            ->all();
    }
}
