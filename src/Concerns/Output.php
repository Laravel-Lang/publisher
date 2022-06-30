<?php

namespace LaravelLang\Publisher\Concerns;

trait Output
{
    protected function info(string $message, string $style = 'fg=green'): void
    {
        $this->line($message, $style);
    }

    protected function line(string $message, ?string $style = null): void
    {
        $line = ! empty($style) ? sprintf('<%s>%s</>', $style, $message) : $message;

        $this->output->writeln($line);
    }
}
