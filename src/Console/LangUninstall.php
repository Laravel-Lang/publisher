<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Facades\Locale;

final class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall'
    . ' {locales* : Space-separated list of, eg: de tk it}'
    . ' {--j|json : Install JSON files}';

    protected $description = 'Uninstall localizations.';

    public function handle()
    {
        $this->delete(
            $this->locales(),
            $this->json()
        );

        $this->result
            ->setMessage('No uninstalled localizations.')
            ->show();
    }

    protected function delete(array $locales, bool $json = false): void
    {
        $locales === ['*']
            ? $this->deleteSome(Locale::installed(), $json)
            : $this->deleteSome($locales, $json);
    }

    protected function deleteSome(array $locales, bool $json = false): void
    {
        foreach ($locales as $locale) {
            $this->result->merge(
                $this->localization->delete($locale, $json)
            );
        }
    }
}
