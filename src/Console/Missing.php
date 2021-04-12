<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Services\Missing as MissingSupport;
use Illuminate\Console\Command;

class Missing extends Command
{
    protected $signature = 'lang:missing';

    protected $description = 'Helps identify missing localizations for publication.';

    protected $hidden = true;

    public function handle(MissingSupport $missing)
    {
        if ($this->missingError($missing) || $this->unnecessaryError($missing)) {
            return;
        }

        $this->info('All localizations are available!');
    }

    protected function missingError(MissingSupport $missing): bool
    {
        return $this->isError('We found the following localizations unavailable for installation:', $missing->missing());
    }

    protected function unnecessaryError(MissingSupport $missing): bool
    {
        return $this->isError('We found the following unnecessary localizations:', $missing->unnecessary());
    }

    protected function isError(string $message, array $locales): bool
    {
        if (! empty($locales)) {
            $this->warn($message);
            $this->warn(implode(', ', $locales));

            return true;
        }

        return false;
    }
}
