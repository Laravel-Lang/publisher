<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Update extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('update', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('updating', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('updated', $as_title);
    }
}
