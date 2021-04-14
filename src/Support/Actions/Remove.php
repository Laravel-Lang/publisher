<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Remove extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('remove', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('removing', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log('Convert text to TitleCase for ' . __FUNCTION__);

        return $this->text('removed', $as_title);
    }
}
