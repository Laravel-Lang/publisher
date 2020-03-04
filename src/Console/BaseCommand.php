<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Localization;
use Helldar\LaravelLangPublisher\Contracts\Result;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    /** @var \Helldar\LaravelLangPublisher\Contracts\Localization */
    protected $localization;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Result */
    protected $result;

    public function __construct(Localization $localization, Result $result)
    {
        parent::__construct();

        $this->localization = $localization;

        $this->result = $result->setOutput($this);
    }
}
