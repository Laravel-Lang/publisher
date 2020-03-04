<?php

namespace Helldar\LaravelLangPublisher\Console;

use function compact;
use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File;

class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall {locales* : Localizations to uninstall}';

    protected $description = 'Uninstall localizations.';

    protected $result = [];

    public function handle()
    {
        $this->uninstall((array) $this->argument('locales'));
        $this->showResult($this->result, 'No uninstalled localizations.');
    }

    protected function uninstall(array $locales): void
    {
        foreach ($locales as $locale) {
            $status = $this->status(
                $this->delete($locale)
            );

            $this->pushResult($locale, $status);
        }
    }

    protected function delete(string $locale): bool
    {
        try {
            return File::deleteDirectory(
                Path::target($locale)
            );
        } catch (\Exception$exception) {
            return false;
        }
    }

    protected function pushResult(string $locale, string $status)
    {
        $this->result[] = compact('locale', 'status');
    }

    protected function status(bool $success = false): string
    {
        return $success ? 'uninstalled' : 'error';
    }
}
