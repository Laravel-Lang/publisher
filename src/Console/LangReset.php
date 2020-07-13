<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Processors\ResetJson;
use Helldar\LaravelLangPublisher\Services\Processors\ResetPhp;

final class LangReset extends BaseCommand
{
    protected $signature = 'lang:reset'
    . ' {locales? : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Install JSON files}'
    . ' {--f|full : Reset files without excluded keys}';

    protected $description = 'Resets installed locations.';

    protected $action = 'reset';

    protected $action_default = true;

    public function handle()
    {
        $this->setProcessor(ResetPhp::class, ResetJson::class);

        $this->exec(
            Locale::installed($this->wantsJson())
        );

        $this->result
            ->setMessage('Files have not been reset.')
            ->show();
    }
}
