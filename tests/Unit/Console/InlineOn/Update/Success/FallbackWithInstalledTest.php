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

namespace Tests\Unit\Console\InlineOn\Update\Success;

use DragonCode\Support\Facades\Filesystem\Directory;
use LaravelLang\LocaleList\Locale;
use Tests\Unit\Console\InlineOn\TestCase;

class FallbackWithInstalledTest extends TestCase
{
    protected Locale $locale = Locale::German;

    /**
     * Json fallbacks doesn't work in the Laravel Framework.
     *
     * @see https://github.com/laravel/framework/issues/41565
     */
    public function testFallbackWithInstalled(): void
    {
        $this->forceDeleteLocale(Locale::German);

        Directory::ensureDirectory($this->config->langPath(Locale::German));

        $this->assertSame('Tous droits réservés.', $this->trans('All rights reserved.'));
        $this->assertSame('Interdit', $this->trans('Forbidden'));
        $this->assertSame('Aller à la page', $this->trans('Go to page :page'));
        $this->assertSame('Bonjour !', $this->trans('Hello!'));

        $this->assertSame('Ces identifiants ne correspondent pas à nos enregistrements.', $this->trans('auth.failed'));
        $this->assertSame('Le mot de passe fourni est incorrect.', $this->trans('auth.password'));

        $this->assertSame(
            'Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes.',
            $this->trans('auth.throttle')
        );

        $this->assertSame('Suivant &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Précédent', $this->trans('pagination.previous'));

        $this->assertSame('Ce champ doit être accepté.', $this->trans('validation.accepted'));

        $this->assertSame(
            'Le champ :attribute doit être accepté quand :other a la valeur :value.',
            $this->trans('validation.accepted_if')
        );

        $this->assertSame('Le champ :attribute n\'est pas une URL valide.', $this->trans('validation.active_url'));

        $this->assertSame(
            'Le tableau doit contenir entre :min et :max éléments.',
            $this->trans('validation.between.array')
        );

        $this->assertSame(
            'La taille du fichier doit être comprise entre :min et :max kilo-octets.',
            $this->trans('validation.between.file')
        );

        $this->assertSame('prénom', $this->trans('validation.attributes.first_name'));
        $this->assertSame('nom', $this->trans('validation.attributes.last_name'));
        $this->assertSame('âge', $this->trans('validation.attributes.age'));
        $this->assertSame('Le champ prénom est obligatoire.', $this->trans('validation.custom.first_name.required'));

        $this->assertSame(
            'Le champ :attribute doit être une chaîne de caractères.',
            $this->trans('validation.custom.first_name.string')
        );

        $this->artisanLangUpdate();

        $this->assertSame('Alle Rechte vorbehalten.', $this->trans('All rights reserved.'));
        $this->assertSame('Interdit', $this->trans('Forbidden'));
        $this->assertSame('Aller à la page', $this->trans('Go to page :page'));
        $this->assertSame('Bonjour !', $this->trans('Hello!'));

        $this->assertSame('Ces identifiants ne correspondent pas à nos enregistrements.', $this->trans('auth.failed'));
        $this->assertSame('Le mot de passe fourni est incorrect.', $this->trans('auth.password'));

        $this->assertSame(
            'Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes.',
            $this->trans('auth.throttle')
        );

        $this->assertSame('Suivant &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Précédent', $this->trans('pagination.previous'));

        $this->assertSame('Dieses Feld muss akzeptiert werden.', $this->trans('validation.accepted'));

        $this->assertSame(
            'Le champ :attribute doit être accepté quand :other a la valeur :value.',
            $this->trans('validation.accepted_if')
        );

        $this->assertSame('Le champ :attribute n\'est pas une URL valide.', $this->trans('validation.active_url'));

        $this->assertSame(
            'Dieser Inhalt muss zwischen :min & :max Elemente haben.',
            $this->trans('validation.between.array')
        );

        $this->assertSame(
            'Diese Datei muss zwischen :min & :max Kilobytes groß sein.',
            $this->trans('validation.between.file')
        );

        $this->assertSame('Vorname', $this->trans('validation.attributes.first_name'));
        $this->assertSame('nom', $this->trans('validation.attributes.last_name'));
        $this->assertSame('âge', $this->trans('validation.attributes.age'));
        $this->assertSame('Dieses Feld muss ausgefüllt werden.', $this->trans('validation.custom.first_name.required'));

        $this->assertSame(
            'Le champ :attribute doit être une chaîne de caractères.',
            $this->trans('validation.custom.first_name.string')
        );
    }
}
