<?php

namespace Helldar\LaravelLangPublisher\Support\Actions;

final class Uninstall extends Action
{
    public function future(bool $as_title = false): string
    {
        return $this->text('uninstall', $as_title);
    }

    public function present(bool $as_title = false): string
    {
        return $this->text('uninstalling', $as_title);
    }

    public function past(bool $as_title = false): string
    {
        return $this->text('uninstalled', $as_title);
    }
}
