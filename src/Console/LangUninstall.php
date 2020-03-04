<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales* : Localizations to uninstall}';

    protected $description = 'Uninstall localizations.';

    public function handle()
    {
        $this->delete($this->locales());

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }

    protected function delete(array $locales): void
    {
        $locales === ['*']
            ? $this->deleteSome(Locale::installed())
            : $this->deleteSome($locales);
    }

    protected function deleteSome(array $locales): void
    {
        foreach ($locales as $locale) {
            $this->result->merge(
                $this->localization->delete($locale)
            );
        }
    }
}
