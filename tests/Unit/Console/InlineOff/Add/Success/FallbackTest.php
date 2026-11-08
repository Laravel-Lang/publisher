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

namespace Tests\Unit\Console\InlineOff\Add\Success;

use LaravelLang\LocaleList\Locale;
use Tests\Unit\Console\InlineOff\TestCase;

class FallbackTest extends TestCase
{
    protected Locale $fallbackLocale = Locale::French;

    /**
     * Json fallbacks doesn't work in the Laravel Framework.
     *
     * @see https://github.com/laravel/framework/issues/41565
     */
    public function testFallback(): void
    {
        $this->setAppLocale(Locale::German);

        $this->assertSame('French Foo 1', $this->trans('Foo 1'));
        $this->assertSame('French Foo 2', $this->trans('Foo 2'));
        $this->assertSame('French Foo 3', $this->trans('Foo 3'));

        $this->assertSame('French Bar 1', $this->trans('Bar 1'));
        $this->assertSame('French Bar 2', $this->trans('Bar 2'));
        $this->assertSame('French Bar 3', $this->trans('Bar 3'));

        $this->assertSame('French Baq 1', $this->trans('Baq 1'));
        $this->assertSame('French Baq 2', $this->trans('Baq 2'));
        $this->assertSame('French Baq 3', $this->trans('Baq 3'));

        $this->assertSame('Baw 1', $this->trans('Baw 1'));
        $this->assertSame('Baw 2', $this->trans('Baw 2'));
        $this->assertSame('Baw 3', $this->trans('Baw 3'));

        $this->assertSame('Tous droits réservés.', $this->trans('All rights reserved.'));

        $this->assertSame('Le champ :attribute doit être accepté.', $this->trans('validation.accepted'));

        $this->assertSame(
            'Le tableau :attribute doit contenir entre :min et :max éléments.',
            $this->trans('validation.between.array')
        );

        $this->assertSame(
            'La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.',
            $this->trans('validation.between.file')
        );

        $this->assertSame(
            'Le champ :attribute est obligatoire.',
            $this->trans('validation.custom.first_name.required')
        );

        $this->assertSame('prénom', $this->trans('validation.attributes.first_name'));

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

        $this->assertSame('Alle Rechte vorbehalten.', $this->trans('All rights reserved.'));

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
