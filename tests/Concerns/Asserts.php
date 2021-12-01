<?php

/*
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Concerns;

trait Asserts
{
    protected function checkExists(string $filename, string $locale): void
    {
        $message = sprintf('The "%s" file for "%s" localization must not exist.', $filename, $locale);

        $this->assertFileExists($this->resourcesPath($filename), $message);
    }

    protected function checkDoesntExist(string $filename, string $locale): void
    {
        $message = sprintf('The "%s" file for "%s" localization must exist.', $filename, $locale);

        $this->assertFileDoesNotExist($this->resourcesPath($filename), $message);
    }
}
