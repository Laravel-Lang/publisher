<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Helpers\Locales;
use Helldar\LaravelLangPublisher\Processors\Remove as Processor;
use Helldar\Support\Facades\Helpers\Arr;

class Remove extends Base
{
    protected $signature = 'lang:rm'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Remove localizations.';

    protected $processor = Processor::class;

    protected function targetLocales(): array
    {
        $locales = $this->getLocales();

        return Arr::only($locales, parent::targetLocales());
    }

    protected function getAllLocales(): array
    {
        return Locales::installed();
    }
}
