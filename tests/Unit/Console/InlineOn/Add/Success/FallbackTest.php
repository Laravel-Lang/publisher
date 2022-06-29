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

namespace Tests\Unit\Console\InlineOn\Add\Success;

use LaravelLang\Publisher\Constants\Locales;
use Tests\Unit\Console\InlineOn\TestCase;

class FallbackTest extends TestCase
{
    protected Locales $fallback_locale = Locales::FRENCH;

    /**
     * Json fallbacks doesn't work in the Laravel Framework.
     *
     * @see https://github.com/laravel/framework/issues/41565
     *
     * @return void
     */
    public function testFallback(): void
    {
        $this->setAppLocale(Locales::GERMAN);

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

        $this->assertSame('Ce champ doit être accepté.', $this->trans('validation.accepted'));
        $this->assertSame('Le tableau doit contenir entre :min et :max éléments.', $this->trans('validation.between.array'));
        $this->assertSame('La taille du fichier doit être comprise entre :min et :max kilo-octets.', $this->trans('validation.between.file'));
        $this->assertSame('Le champ prénom est obligatoire.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('prénom', $this->trans('validation.attributes.first_name'));

        $this->assertDirectoryDoesNotExist($this->config->langPath(Locales::GERMAN));

        $this->artisanLangAdd(Locales::GERMAN, true);

        $this->assertDirectoryExists($this->config->langPath(Locales::GERMAN));

        $this->assertFileExists($this->config->langPath('de.json'));
        $this->assertFileExists($this->config->langPath(Locales::GERMAN, 'validation.php'));
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

        $this->assertSame('Dieses Feld muss akzeptiert werden.', $this->trans('validation.accepted'));
        $this->assertSame('Dieser Inhalt muss zwischen :min & :max Elemente haben.', $this->trans('validation.between.array'));
        $this->assertSame('Diese Datei muss zwischen :min & :max Kilobytes groß sein.', $this->trans('validation.between.file'));
        $this->assertSame('Dieses Feld muss ausgefüllt werden.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('Vorname', $this->trans('validation.attributes.first_name'));
    }
}
