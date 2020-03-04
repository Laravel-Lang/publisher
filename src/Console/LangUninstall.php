<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Path;
use Illuminate\Support\Facades\File;

class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall {locales* : Localizations to uninstall}';

    protected $description = 'Uninstall localizations.';

    public function handle()
    {
        $this->result->setMessages('No uninstalled localizations.', 'uninstalled');

        $this->uninstall((array) $this->argument('locales'));

        $this->result->show();
    }

    protected function uninstall(array $locales): void
    {
        foreach ($locales as $locale) {
            $result = $this->delete($locale);

            $this->result->push($locale, $result);
        }
    }

    protected function delete(string $locale): bool
    {
        return File::deleteDirectory(
            Path::target($locale)
        );
    }
}
