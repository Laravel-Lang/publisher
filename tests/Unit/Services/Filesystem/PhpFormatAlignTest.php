<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Services\Filesystem;

use LaravelLang\Config\Enums\Name;
use LaravelLang\Publisher\Services\Filesystem\Php;
use Tests\TestCase;

/** Characterization test for the `align` option: `=>` operators line up per nesting level. */
class PhpFormatAlignTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set(Name::Shared() . '.align', true);
    }

    public function testAlignsArrowsPerLevel(): void
    {
        $path = $this->config->langPath('en/sample.php');

        (new Php)->store($path, [
            'a'                  => 'A',
            'long_key'           => 'B',
            'nested.x'           => 'C',
            'nested.longer_key'  => 'D',
        ]);

        $this->assertSame(
            <<<'PHP'
                <?php

                declare(strict_types=1);

                return [
                    'a'        => 'A',
                    'long_key' => 'B',
                    'nested'   => [
                        'longer_key' => 'D',
                        'x'          => 'C',
                    ],
                ];

                PHP,
            file_get_contents($path)
        );
    }
}
