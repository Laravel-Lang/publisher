<?php

namespace Helldar\LaravelLangPublisher\Traits;

trait Jsonable
{
    /** @var bool */
    protected $is_json = false;

    protected function isCurrentJson(): bool
    {
        return $this->is_json;
    }
}
