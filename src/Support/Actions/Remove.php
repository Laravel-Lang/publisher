<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Remove extends Action
{
    public function future(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('remove', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('removing', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        $this->log($this->loggableMessage(), __FUNCTION__, $as_title);

        return $this->text('removed', $as_title);
    }
}
