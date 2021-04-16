<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Add extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('add', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('adding', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('added', $as_title);
    }
}
