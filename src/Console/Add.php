<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
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
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Processors\Add as Processor;

class Add extends Base
{
    protected $signature = 'lang:add'
    . ' {locales?* : Space-separated list of, eg: de tk it}';

    protected $description = 'Install new localizations.';

    protected $processor = Processor::class;

    protected function targetLocales(): array
    {
        return $this->getLocales();
    }

    protected function getAllLocales(): array
    {
        return Locales::available();
    }
}
