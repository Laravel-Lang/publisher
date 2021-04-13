<?php

namespace Helldar\LaravelLangPublisher\Support;

use Closure;
use Helldar\LaravelLangPublisher\Concerns\Logger;
use Helldar\Support\Facades\Helpers\Arr as ArrSupport;

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

        return array_values(array_filter(array_unique($array)));
    }

    /**
     * Getting the first element of an array.
     *
     * @param  array  $array
     *
     * @return mixed
     */
    public function first(array $array)
    {
        $this->log('Getting the first element of an array...');

        return array_shift($array);
    }

    /**
     * Getting array keys.
     *
     * @param  array  $array
     *
     * @return array
     */
    public function keys(array $array): array
    {
        $this->log('Getting array keys...');

        return array_keys($array);
    }

    /**
     * Transforming an array using the callback function.
     *
     * @param  array  $array
     * @param  \Closure  $callback
     *
     * @return array
     */
    public function transform(array $array, Closure $callback): array
    {
        $this->log('Transforming an array using the callback function...');

        return ArrSupport::map($array, $callback);
    }
}
