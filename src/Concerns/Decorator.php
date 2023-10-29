<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Concerns;

trait Decorator
{
    protected function decorate(string $locale, array $values): array
    {
        foreach ($values as &$value) {
            if (is_array($value)) {
                $value = $this->decorate($locale, $values);

                continue;
            }

            $value = $this->decorator->convert($locale, $value);
        }

        return $values;
    }
}
