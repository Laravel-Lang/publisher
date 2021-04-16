<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Reset extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('reset', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('resetting', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('reset', $as_title);
    }
}
