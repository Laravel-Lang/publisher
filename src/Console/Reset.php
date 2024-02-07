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

use LaravelLang\Publisher\Processors\Processor;
use LaravelLang\Publisher\Processors\Reset as ResetProcessor;

class Reset extends Base
{
    protected $signature = 'lang:reset';

    protected $description = 'Resets installed localizations.';

    protected ?string $question = 'Are you sure you want to reset localization files?';

    protected Processor|string $processor = ResetProcessor::class;

    public function handle(): void
    {
        if ($this->confirm($this->question)) {
            parent::handle();
        }
    }
}
