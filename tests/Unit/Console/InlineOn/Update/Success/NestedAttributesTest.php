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

class NestedAttributesTest extends TestCase
{
    protected Locale $fallbackLocale = Locale::English;

    public function testNested(): void
    {
        $this->forceDeleteLocale(Locale::English);
        $this->forceDeleteLocale(Locale::French);

        $this->copyFixtures();

        Directory::ensureDirectory($this->config->langPath(Locale::French));

        $this->artisanLangUpdate();

        $this->assertSame([
            'accepted'    => 'This field must be accepted.',
            'accepted_if' => 'The :attribute must be accepted when :other is :value.',
            'active_url'  => 'The :attribute is not a valid URL.',

            'between' => [
                'array' => 'This field must have between :min and :max items.',
                'file'  => 'This field must be between :min and :max kilobytes.',
            ],

            'attributes' => [
                'age'        => 'age',
                'first_name' => 'first name',
                'last_name'  => 'last name',

                'list.jobs'     => 'List of jobs',
                'list.vehicles' => 'List of vehicles',

                'timeplan'            => 'Timeplan',
                'timeplan.monday'     => 'Monday',
                'timeplan.monday.0.0' => 'Monday (from)',
                'timeplan.monday.0.1' => 'Monday (to)',
                'timeplan.monday.1.0' => 'Monday (from)',
                'timeplan.monday.1.1' => 'Monday (to)',
            ],

            'custom' => [
                'first_name' => [
                    'required' => 'This field is required.',
                    'string'   => 'First name must be a string.',
                ],
            ],
        ], require lang_path('en/validation.php'));

        $this->assertSame([
            'accepted'    => 'Ce champ doit être accepté.',
            'accepted_if' => 'Le champ :attribute doit être accepté quand :other a la valeur :value.',
            'active_url'  => 'Le champ :attribute n\'est pas une URL valide.',

            'between' => [
                'array' => 'Le tableau doit contenir entre :min et :max éléments.',
                'file'  => 'La taille du fichier doit être comprise entre :min et :max kilo-octets.',
            ],

            'attributes' => [
                'age'        => 'âge',
                'first_name' => 'prénom',
                'last_name'  => 'nom',

                'list.jobs'     => 'Liste des dossiers',
                'list.vehicles' => 'Liste des véhicules',

                'timeplan'            => 'Horaire',
                'timeplan.monday'     => 'Lundi',
                'timeplan.monday.0.0' => 'Lundi (de)',
                'timeplan.monday.0.1' => 'Lundi (à)',
                'timeplan.monday.1.0' => 'Lundi (de)',
                'timeplan.monday.1.1' => 'Lundi (à)',
            ],

            'custom' => [
                'first_name' => [
                    'required' => 'Le champ prénom est obligatoire.',
                    'string'   => 'Le champ :attribute doit être une chaîne de caractères.',
                ],
            ],
        ], require lang_path('fr/validation.php'));
    }
}
