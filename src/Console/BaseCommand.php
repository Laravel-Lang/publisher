<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\Facades\Locale;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Support\Result;
use Helldar\LaravelLangPublisher\Traits\Containable;
use Helldar\LaravelLangPublisher\Traits\Containers\Pathable;
use Helldar\LaravelLangPublisher\Traits\Containers\Processable;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

abstract class BaseCommand extends Command
{
    use Containable;
    use Processable;
    use Pathable;

    /** @var \Helldar\LaravelLangPublisher\Support\Result */
    protected $result;

    protected $select_template = 'What languages to %s? (specify the necessary localizations separated by commas)';

    protected $select_all_template = 'Do you want to %s all localizations?';

    protected $action = 'install';

    protected $action_default = false;

    public function __construct(Result $result)
    {
        parent::__construct();

        $this->result = $result->setOutput($this);
    }

    protected function locales(): array
    {
        return (array) $this->argument('locales');
    }

    protected function available(): array
    {
        return Locale::available();
    }

    protected function installed(): array
    {
        return Locale::installed($this->wantsJson());
    }

    protected function select(array $locales): array
    {
        $question = sprintf($this->select_all_template, $this->action);

        return $this->confirm($question, $this->action_default)
            ? ['*']
            : $this->wrapSelectedValues($locales, $this->choiceLocales($locales));
    }

    protected function isForce(): bool
    {
        return $this->hasOption('force') && (bool) $this->option('force');
    }

    protected function isFull(): bool
    {
        return $this->hasOption('full') && (bool) $this->option('full');
    }

    protected function wantsJson(): bool
    {
        return (bool) $this->option('json')
            || (bool) $this->option('jet')
            || (bool) $this->option('fortify')
            || (bool) $this->option('cashier')
            || (bool) $this->option('nova');
    }

    protected function setProcessor(string $php, string $json): void
    {
        $this->processor = $this->wantsJson() ? $json : $php;
    }

    protected function exec(array $locales): void
    {
        foreach ($this->getLocales($locales) as $locale) {
            $this->result->merge(
                $this->localization()
                    ->processor($this->getProcessor())
                    ->force($this->isForce())
                    ->full($this->isFull())
                    ->run($locale)
            );
        }
    }

    protected function getLocales(array $locales): array
    {
        $items = $this->locales() ?: $this->select($locales);

        return $items === ['*'] ? $locales : $items;
    }

    protected function localization(): Localizationable
    {
        return app(Localization::class);
    }

    protected function wrapSelectedValues(array $available, $selected): array
    {
        return Arr::wrap(
            is_numeric($selected)
                ? Arr::get($available, (int) $selected)
                : $selected
        );
    }

    protected function choiceLocales(array $locales)
    {
        return $this->choice(
            sprintf($this->select_template, $this->action),
            $locales,
            null,
            null,
            true
        );
    }
}
