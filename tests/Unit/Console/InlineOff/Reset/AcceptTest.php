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

namespace Tests\Unit\Console\InlineOff\Reset;

use LaravelLang\Publisher\Constants\Locales as LocaleCode;
use Tests\Unit\Console\InlineOff\TestCase;

class AcceptTest extends TestCase
{
    protected LocaleCode $locale = LocaleCode::FRENCH;

    protected array $preinstall = [
        LocaleCode::FRENCH,
    ];

    public function testYes(): void
    {
        $this->assertSame('Tous droits réservés.', $this->trans('All rights reserved.'));
        $this->assertSame('Interdit', $this->trans('Forbidden'));
        $this->assertSame('Aller à la page', $this->trans('Go to page :page'));
        $this->assertSame('Bonjour !', $this->trans('Hello!'));

        $this->assertSame('Ces identifiants ne correspondent pas à nos enregistrements.', $this->trans('auth.failed'));
        $this->assertSame('Le mot de passe fourni est incorrect.', $this->trans('auth.password'));
        $this->assertSame('Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes.', $this->trans('auth.throttle'));

        $this->assertSame('Suivant &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Précédent', $this->trans('pagination.previous'));

        $this->assertSame('Le champ :attribute doit être accepté.', $this->trans('validation.accepted'));
        $this->assertSame('Le champ :attribute doit être accepté quand :other a la valeur :value.', $this->trans('validation.accepted_if'));
        $this->assertSame('Le champ :attribute n\'est pas une URL valide.', $this->trans('validation.active_url'));
        $this->assertSame('Le tableau :attribute doit contenir entre :min et :max éléments.', $this->trans('validation.between.array'));
        $this->assertSame('La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.', $this->trans('validation.between.file'));
        $this->assertSame('prénom', $this->trans('validation.attributes.first_name'));
        $this->assertSame('nom', $this->trans('validation.attributes.last_name'));
        $this->assertSame('âge', $this->trans('validation.attributes.age'));
        $this->assertSame('Le champ :attribute est obligatoire.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('Le champ :attribute doit être une chaîne de caractères.', $this->trans('validation.custom.first_name.string'));

        $this->artisan('lang:reset')
            ->expectsConfirmation('Are you sure you want to reset localization files?', 'yes')
            ->run();

        $this->reloadLocales();

        $this->assertSame('Tous droits réservés.', $this->trans('All rights reserved.'));
        $this->assertSame('Forbidden', $this->trans('Forbidden'));
        $this->assertSame('Go to page :page', $this->trans('Go to page :page'));
        $this->assertSame('Hello!', $this->trans('Hello!'));

        $this->assertSame('Ces identifiants ne correspondent pas à nos enregistrements.', $this->trans('auth.failed'));
        $this->assertSame('Le mot de passe fourni est incorrect.', $this->trans('auth.password'));
        $this->assertSame('Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans :seconds secondes.', $this->trans('auth.throttle'));

        $this->assertSame('Suivant &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Précédent', $this->trans('pagination.previous'));

        $this->assertSame('Le champ :attribute doit être accepté.', $this->trans('validation.accepted'));
        $this->assertSame('validation.accepted_if', $this->trans('validation.accepted_if'));
        $this->assertSame('validation.active_url', $this->trans('validation.active_url'));
        $this->assertSame('Le tableau :attribute doit contenir entre :min et :max éléments.', $this->trans('validation.between.array'));
        $this->assertSame('La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.', $this->trans('validation.between.file'));
        $this->assertSame('prénom', $this->trans('validation.attributes.first_name'));
        $this->assertSame('validation.attributes.last_name', $this->trans('validation.attributes.last_name'));
        $this->assertSame('validation.attributes.age', $this->trans('validation.attributes.age'));
        $this->assertSame('Le champ :attribute est obligatoire.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('validation.custom.first_name.string', $this->trans('validation.custom.first_name.string'));
    }
}
