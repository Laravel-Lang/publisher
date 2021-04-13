<?php

namespace Helldar\LaravelLangPublisher\Services\Command;

use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\LaravelLangPublisher\Console\BaseCommand;
use Helldar\LaravelLangPublisher\Contracts\Actionable;
use Helldar\Support\Concerns\Makeable;

/**
 * @method static Locales make(BaseCommand $command, Actionable $action, array $locales)
 */
final class Locales
{
    use Logger;
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
        $this->log('Object initialization: ' . self::class);

        $this->command = $command;
        $this->action  = $action;
        $this->locales = $locales;
    }

    public function get(): array
    {
        $input = $this->input();

        if ($input === ['*'] && $this->confirm()) {
            $this->log('Returning a list of all localizations...');

            return $this->locales;
        }

        return $this->select();
    }

    protected function select(): array
    {
        $this->log('Displaying an interactive question with a choice of localizations...');

        if ($locales = $this->ask()) {
            return $locales;
        }

        return $this->ask();
    }

    protected function confirm(): bool
    {
        $this->log('Confirmation of processing of all localizations...');

        return $this->command->confirm($this->confirmQuestion());
    }

    protected function ask(): ?array
    {
        $this->log('Localization selection request...');

        return $this->command->choice($this->choiceQuestion(), $this->locales);
    }

    protected function input(): array
    {
        $this->log('Getting a list of localizations from arguments...');

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
