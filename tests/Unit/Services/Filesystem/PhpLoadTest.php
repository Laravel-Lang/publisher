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

use LaravelLang\Publisher\Services\Filesystem\Php;
use Tests\TestCase;

/** Characterization tests for how PHP translation files are read back. */
class PhpLoadTest extends TestCase
{
    public function testFlattensDropsEmptyValuesAndIgnoredKeys(): void
    {
        $path = $this->config->langPath('en/sample.php');

        file_put_contents($path, <<<'PHP'
            <?php

            return [
                'plain' => 'Plain',
                'empty' => '',
                'zero' => '0',
                'flag' => false,
                'nothing' => null,
                'nested' => ['deep' => ['key' => 'Value'], 'blank' => []],
                'custom' => ['attribute-name' => ['rule-name' => 'Ignored']],
            ];
            PHP);

        $this->assertSame(
            [
                'plain'           => 'Plain',
                'flag'            => false,
                'nested.deep.key' => 'Value',
            ],
            (new Php)->load($path)
        );
    }

    public function testMissingFileReturnsEmptyArray(): void
    {
        $this->assertSame([], (new Php)->load($this->config->langPath('en/missing.php')));
    }
}
