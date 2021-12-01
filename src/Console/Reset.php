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

use LaravelLang\Publisher\Processors\Reset as Processor;

class Reset extends Base
{
    protected $signature = 'lang:reset'
    . ' {locales?* : Space-separated list of, eg: de tk it}'
    . ' {--full : Delete custom keys}';

    protected $description = 'Resets installed locations.';

    protected $processor = Processor::class;

    protected function targetLocales(): array
    {
        return $this->getLocales();
    }
}
