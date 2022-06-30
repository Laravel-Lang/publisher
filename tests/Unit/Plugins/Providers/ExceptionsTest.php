<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Plugins\Providers;

use LaravelLang\Publisher\Exceptions\UnknownPluginInstanceException;
use LaravelLang\Publisher\Plugins\Plugin;
use LaravelLang\Publisher\Plugins\Provider;
use RuntimeException;
use Tests\Fixtures\Incorrect\BasePathDoesntExistProvider;
use Tests\Fixtures\Incorrect\BasePathProvider;
use Tests\Fixtures\Incorrect\ExceptionProvider;
use Tests\Fixtures\Incorrect\Plugin as IncorrectPlugin;
use Tests\TestCase;

class ExceptionsTest extends TestCase
{
    public function testExtends(): void
    {
        $this->expectException(UnknownPluginInstanceException::class);
        $this->expectExceptionMessage(sprintf('The %s class is not a %s instance.', IncorrectPlugin::class, Plugin::class));

        $this->app->register(ExceptionProvider::class);
    }

    public function testBasePathProperty(): void
    {
        $this->expectError();
        $this->expectErrorMessage(sprintf('Typed property %s::$base_path must not be accessed before initialization', Provider::class));

        $this->app->register(BasePathProvider::class);
    }

    public function testDoesntExistBasePath(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf(
            'The %s class must contain the definition of the $base_path property. The path must be existing.',
            BasePathDoesntExistProvider::class
        ));

        $this->app->register(BasePathDoesntExistProvider::class);
    }
}
