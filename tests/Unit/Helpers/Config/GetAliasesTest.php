<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace Tests\Unit\Helpers\Config;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use LaravelLang\Publisher\Facades\Helpers\Locales;
use LaravelLang\Publisher\Helpers\Config;

class GetAliasesTest extends BaseTest
{
    protected array $preinstall = [
        LocaleCode::GERMAN,
        LocaleCode::GERMAN_SWITZERLAND,
    ];

    public function testGetAliases(): void
    {
        $this->assertSame([
            LocaleCode::GERMAN->value => 'de-DE',

            LocaleCode::GERMAN_SWITZERLAND->value => 'de-CH',
        ], $this->config->getAliases());
    }

    public function testInstalled(): void
    {
        $this->assertSame([
            'de-CH',
            'de-DE',
            'en',
            'fr',
            'ru',
        ], Locales::installed());
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set(Config::PUBLIC_KEY . '.aliases', [
            LocaleCode::GERMAN->value => 'de-DE',

            LocaleCode::GERMAN_SWITZERLAND->value => 'de-CH',
        ]);
    }
}
