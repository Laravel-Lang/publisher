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

namespace Tests\Unit\Console\InlineOff\Add\Success;

use LaravelLang\Locales\Enums\Locale;
use Tests\Unit\Console\InlineOff\TestCase;

class DefaultTest extends TestCase
{
    public function testDefault(): void
    {
        $this->assertSame('English Foo 1', $this->trans('Foo 1'));
        $this->assertSame('English Foo 2', $this->trans('Foo 2'));
        $this->assertSame('English Foo 3', $this->trans('Foo 3'));

        $this->assertSame('English Bar 1', $this->trans('Bar 1'));
        $this->assertSame('English Bar 2', $this->trans('Bar 2'));
        $this->assertSame('English Bar 3', $this->trans('Bar 3'));

        $this->assertSame('English Baq 1', $this->trans('Baq 1'));
        $this->assertSame('English Baq 2', $this->trans('Baq 2'));
        $this->assertSame('English Baq 3', $this->trans('Baq 3'));

        $this->assertSame('Baw 1', $this->trans('Baw 1'));
        $this->assertSame('Baw 2', $this->trans('Baw 2'));
        $this->assertSame('Baw 3', $this->trans('Baw 3'));

        $this->assertSame('All rights reserved.', $this->trans('All rights reserved.'));

        $this->assertSame('The :attribute must be accepted.', $this->trans('validation.accepted'));
        $this->assertSame(
            'The :attribute must have between :min and :max items.',
            $this->trans('validation.between.array')
        );
        $this->assertSame(
            'The :attribute must be between :min and :max kilobytes.',
            $this->trans('validation.between.file')
        );
        $this->assertSame('The :attribute field is required.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('first name', $this->trans('validation.attributes.first_name'));

        $this->assertDirectoryDoesNotExist($this->config->langPath(Locale::German));

        $this->artisanLangAdd(Locale::German, true);

        $this->assertDirectoryExists($this->config->langPath(Locale::German));

        $this->assertFileExists($this->config->langPath('de.json'));
        $this->assertFileExists($this->config->langPath(Locale::German, 'validation.php'));
        $this->assertFileExists($this->config->langPath('vendor/baq/de.json'));

        $this->assertFileDoesNotExist($this->config->langPath('vendor/custom/de.json'));

        $this->assertSame('German Foo 1', $this->trans('Foo 1'));
        $this->assertSame('German Foo 2', $this->trans('Foo 2'));
        $this->assertSame('German Foo 3', $this->trans('Foo 3'));

        $this->assertSame('German Bar 1', $this->trans('Bar 1'));
        $this->assertSame('German Bar 2', $this->trans('Bar 2'));
        $this->assertSame('German Bar 3', $this->trans('Bar 3'));

        $this->assertSame('German Baq 1', $this->trans('Baq 1'));
        $this->assertSame('German Baq 2', $this->trans('Baq 2'));
        $this->assertSame('German Baq 3', $this->trans('Baq 3'));

        $this->assertSame('Baw 1', $this->trans('Baw 1'));
        $this->assertSame('Baw 2', $this->trans('Baw 2'));
        $this->assertSame('Baw 3', $this->trans('Baw 3'));

        $this->assertSame(':Attribute muss akzeptiert werden.', $this->trans('validation.accepted'));
        $this->assertSame(
            ':Attribute muss zwischen :min & :max Elemente haben.',
            $this->trans('validation.between.array')
        );
        $this->assertSame(
            ':Attribute muss zwischen :min & :max Kilobytes groß sein.',
            $this->trans('validation.between.file')
        );
        $this->assertSame(
            'Dieses Vorname muss ausgefüllt werden.',
            $this->trans('validation.custom.first_name.required')
        );
        $this->assertSame('Vorname', $this->trans('validation.attributes.first_name'));
    }
}
