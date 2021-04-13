<?php

namespace Helldar\LaravelLangPublisher\Contracts;

interface Actionable
{
    public function future(bool $as_title = false): string;

    public function present(bool $as_title = false): string;

    public function past(bool $as_title = false): string;
}
