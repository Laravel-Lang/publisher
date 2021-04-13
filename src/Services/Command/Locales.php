<?php

namespace Helldar\LaravelLangPublisher\Services\Command;

use Helldar\LaravelLangPublisher\Console\BaseCommand;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\Support\Concerns\Makeable;

/**
 * @method static Locales make(BaseCommand $command, Actionable $action, array $locales)
 */
final class Locales
{
    use Makeable;

    /** @var \Helldar\LaravelLangPublisher\Console\BaseCommand */
    protected $command;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Actionable */
    protected $action;

    protected $locales = [];

    protected $select_template = 'What languages to %s? (specify the necessary localizations separated by commas)';

    protected $select_all_template = 'Do you want to %s all localizations?';

    public function __construct(BaseCommand $command, Actionable $action, array $locales)
    {
        $this->command = $command;
        $this->action  = $action;
        $this->locales = $locales;
    }

    public function get(): array
    {
        $input = $this->input();

        if ($input === ['*'] && $this->confirm()) {
            return $this->locales;
        }

        return $this->select();
    }

    protected function select(): array
    {
        if ($locales = $this->ask()) {
            return $locales;
        }

        return $this->ask();
    }

    protected function confirm(): bool
    {
        return $this->command->confirm($this->confirmQuestion());
    }

    protected function ask(): ?array
    {
        return $this->command->choice($this->choiceQuestion(), $this->locales);
    }

    protected function input(): array
    {
        return (array) $this->command->argument('locales');
    }

    protected function choiceQuestion(): string
    {
        return sprintf($this->select_template, $this->action->future());
    }

    protected function confirmQuestion(): string
    {
        return sprintf($this->select_all_template, $this->action->future());
    }
}
