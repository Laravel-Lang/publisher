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
        $source = $this->load($this->source_path);
        $target = $this->load($this->target_path);

        $result = $this->compare($source, $target);

        $this->store($this->target_path, $result);

        return Status::RESET;
    }

    protected function compare(array $source, array $target): array
    {
        $target = $this->full ? [] : $this->only($target);

        return parent::compare($source, $target);
    }

    protected function only(array $array): array
    {
        return $this->reserved($array, $this->key($this->target_path));
    }
}
