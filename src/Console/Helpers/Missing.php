<?php

namespace Helldar\LaravelLangPublisher\Console\Helpers;

use Helldar\LaravelLangPublisher\Support\Missing as MissingSupport;
use Illuminate\Console\Command;

class Missing extends Command
{
    protected $signature = 'lang:missing';

    protected $description = 'Helps identify missing localizations for publication.';

    protected $hidden = true;

    public function handle(MissingSupport $missing)
    {
        if ($locales = $missing->get()) {
            $this->warn('We found the following localizations unavailable for installation:');
            $this->warn(implode(', ', $locales));

            return;
        }

        $this->info('Congratulations! All localizations are available!');
    }
}
