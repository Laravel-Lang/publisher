<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\LaravelLangPublisher\Concerns\Logger;

final class Arr
{
    use Logger;

    /**
     * Getting unique values.
     *
     * @param  array  $array
     *
     * @return array
     */
    public function unique(array $array): array
    {
        $this->log('Getting unique values...');

        return array_filter(array_unique($array));
    }
}
