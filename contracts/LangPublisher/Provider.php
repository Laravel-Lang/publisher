<?php

declare(strict_types=1);

namespace Helldar\Contracts\LangPublisher;

interface Provider
{
    /**
     * Indicates the base path of the provider.
     *
     * For example, `__DIR__`
     *
     * @return string
     */
    public function basePath(): string;

    /**
     * @return \Helldar\Contracts\LangPublisher\Plugin[]
     */
    public function plugins(): array;
}
