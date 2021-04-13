<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Install extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('install', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('installing', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('installed', $as_title);
    }
}
