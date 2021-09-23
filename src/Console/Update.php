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
use Helldar\LaravelLangPublisher\Processors\Add as Processor;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;

class Update extends Base
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    protected $processor = Processor::class;

    protected function targetLocales(): array
    {
        $locales = parent::targetLocales();

        return Arrayable::of($locales)
            ->addUnique($this->getProtected())
            ->sort()
            ->values()
            ->get();
    }

    protected function getProtected(): array
    {
        return Locales::protects();
    }
}
