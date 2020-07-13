<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Traits\Processors\Deletable;

final class DeleteJson extends BaseProcessor
{
    use Deletable;

    protected $extension = 'json';
}
