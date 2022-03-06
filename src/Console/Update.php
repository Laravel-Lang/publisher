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

use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Processors\Add as Processor;

class Update extends Base
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    protected $processor = Processor::class;

    protected function targetLocales(): array
    {
        $locales   = parent::targetLocales();
        $protected = $this->getProtected();

        return Arrayable::of($locales)
            ->push($protected)
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->get();
    }

    protected function getProtected(): array
    {
        return Locales::protects();
    }
}
