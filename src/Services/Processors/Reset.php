<?php

namespace Helldar\LaravelLangPublisher\Services\Processors;

use Helldar\LaravelLangPublisher\Concerns\Keyable;
use Helldar\LaravelLangPublisher\Concerns\Reservation;
use Helldar\LaravelLangPublisher\Constants\Status;

final class Reset extends Processor
{
    use Keyable;
    use Reservation;

    public function run(): string
    {
        $this->log('Start the handler for execution:', self::class);

        $this->main();
        $this->packages();

        return Status::RESET;
    }

    protected function compare(array $source, array $target): array
    {
        $this->log('Combining arrays...');

        $target = $this->full ? [] : $this->only($target);

        return parent::compare($source, $target);
    }

    protected function only(array $array): array
    {
        $this->log('Getting reserved keys from an array...');

        return $this->reserved($array, $this->key($this->target_path));
    }
}
