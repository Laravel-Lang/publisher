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

namespace LaravelLang\Publisher\Console;

use LaravelLang\Publisher\Exceptions\ProtectedLocaleException;
use LaravelLang\Publisher\Exceptions\UnknownLocaleCodeException;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Processors\Remove as RemoveProcessor;

class Remove extends Base
{
    protected $signature = 'lang:rm {locales?* : Space-separated list of, eg: de tk it} {--force : Forced deletion of localization}';

    protected $description = 'Remove localizations.';

    protected ?string $question = 'Do you want to remove all localizations?';

    protected Processor|string $processor = RemoveProcessor::class;

    protected function locales(): array
    {
        if ($this->confirmAll()) {
            return Locales::installedWithoutProtects();
        }

        $locales = $this->getLocalesArgument();

        foreach ($locales as $locale) {
            if (! Locales::isAvailable($locale)) {
                throw new UnknownLocaleCodeException($locale);
            }

            if (Locales::isProtected($locale) && ! $this->option('force')) {
                throw new ProtectedLocaleException($locale);
            }
        }

        return $locales;
    }
}
