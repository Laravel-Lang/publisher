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

namespace Tests\Main;

use LaravelLang\Publisher\Constants\Config;
use Tests\TestCase;

class EmptyPluginsTest extends TestCase
{
    public function testWarning()
    {
        $this->artisan('lang:add', [
            'locales' => $this->default,
        ])
            ->expectsOutput('Could not find plugins available for processing.')
            ->assertExitCode(0)
            ->run();
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::PRIVATE_KEY . '.plugins', []);
    }
}
