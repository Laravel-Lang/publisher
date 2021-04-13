<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Reset extends Action
{
    public function future(bool $as_title = false): string
    {
        return $this->text('reset', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        return $this->text('resetting', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        return $this->text('reset', $as_title);
    }
}
