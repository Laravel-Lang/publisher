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

/**
 * Characterization tests: they pin the exact bytes written for PHP
 * translation files, so that replacing the third-party formatter and
 * sorter with in-house code can be proven not to change the output.
 */
class PhpFormatTest extends TestCase
{
    protected bool $align = false;

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set(Name::Shared() . '.align', $this->align);
    }

    public function testFormatsNestedKeysWithoutAlign(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                declare(strict_types=1);

                return [
                    'bye' => 'Bye',
                    'hello' => 'Hello',
                    'messages' => [
                        'farewell_long_key' => 'Bye',
                        'greeting' => 'Hi',
                    ],
                ];

                PHP,
            $this->store([
                'hello'                      => 'Hello',
                'bye'                        => 'Bye',
                'messages.greeting'          => 'Hi',
                'messages.farewell_long_key' => 'Bye',
            ])
        );
    }

    public function testEscapesAndCastsValues(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                declare(strict_types=1);

                return [
                    'backslash' => 'ab',
                    'backslash_pair' => 'a\\b',
                    'empty' => '',
                    'number_as_string' => 123,
                    'quote' => 'It\'s',
                ];

                PHP,
            $this->store([
                'quote'            => "It's",
                'backslash'        => 'a\\b',
                'backslash_pair'   => 'a\\\\b',
                'number_as_string' => '123',
                'empty'            => '',
            ])
        );
    }

    public function testSortsKeysIgnoringCaseAndPuttingSymbolsFirst(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                declare(strict_types=1);

                return [
                    'a b' => 'one',
                    'a-b' => 'two',
                    'a_b' => 'three',
                    'alpha' => 'four',
                    'Beta' => 'five',
                    'gamma' => 'six',
                    'Zeta' => 'seven',
                ];

                PHP,
            $this->store([
                'Zeta'  => 'seven',
                'gamma' => 'six',
                'Beta'  => 'five',
                'alpha' => 'four',
                'a_b'   => 'three',
                'a-b'   => 'two',
                'a b'   => 'one',
            ])
        );
    }

    public function testValidationFilePlacesAttributesAndCustomLast(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                declare(strict_types=1);

                return [
                    'accepted' => 'Accepted',
                    'attributes' => [
                        'email' => 'E-mail',
                    ],
                    'custom' => [
                        'email' => [
                            'required' => 'Needed',
                        ],
                    ],
                ];

                PHP,
            $this->store([
                'custom.email.required' => 'Needed',
                'attributes.email'      => 'E-mail',
                'accepted'              => 'Accepted',
            ], 'validation.php')
        );
    }

    public function testEmptyArray(): void
    {
        $this->assertSame(
            "<?php\n\ndeclare(strict_types=1);\n\nreturn [];\n",
            $this->store([])
        );
    }

    protected function store(array $content, string $filename = 'sample.php'): string
    {
        $path = $this->config->langPath('en/' . $filename);

        (new Php)->store($path, $content);

        return file_get_contents($path);
    }
}
