<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Concerns;

trait Keyable
{
    protected function getKeysOnly(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->getKeysOnly($value);

                continue;
            }

            array_push($result, $key);
        }

        return $result;
    }
}
