<?php

namespace Helldar\LaravelLangPublisher\Support;

use Closure;

final class Arr
{
    /**
     * Getting unique values.
     *
     * @param  array  $array
     *
     * @return array
     */
    public function unique(array $array): array
    {
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
        foreach ($array as &$value) {
            $value = $callback($value);
        }

        return $array;
    }
}
