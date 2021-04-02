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
        if ($this->missingError($missing) || $this->unnecessaryError($missing)) {
            return;
        }

        $this->info('Congratulations! All localizations are available!');
    }

    protected function missingError(MissingSupport $missing): bool
    {
        return $this->isError($missing->missing(), 'We found the following localizations unavailable for installation:');
    }

    protected function unnecessaryError(MissingSupport $missing): bool
    {
        return $this->isError($missing->unnecessary(), 'We found the following unnecessary localizations:');
    }

    protected function isError(array $locales, string $message): bool
    {
        if (! empty($locales)) {
            $this->warn($message);
            $this->warn(implode(', ', $locales));

            return true;
        }

        return false;
    }
}
