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

class DefaultWithInstalledTest extends TestCase
{
    protected Locales $fallback_locale = Locales::ENGLISH;

    public function testDefaultWithInstalled(): void
    {
        $this->assertSame('All rights reserved.', $this->trans('All rights reserved.'));
        $this->assertSame('Forbidden', $this->trans('Forbidden'));
        $this->assertSame('Go to page', $this->trans('Go to page :page'));
        $this->assertSame('Hello!', $this->trans('Hello!'));

        $this->assertSame('These credentials do not match our records.', $this->trans('auth.failed'));
        $this->assertSame('The provided password is incorrect.', $this->trans('auth.password'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', $this->trans('auth.throttle'));

        $this->assertSame('Next &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Previous', $this->trans('pagination.previous'));

        $this->assertSame('This field must be accepted.', $this->trans('validation.accepted'));
        $this->assertSame('The :attribute must be accepted when :other is :value.', $this->trans('validation.accepted_if'));
        $this->assertSame('The :attribute is not a valid URL.', $this->trans('validation.active_url'));
        $this->assertSame('This field must have between :min and :max items.', $this->trans('validation.between.array'));
        $this->assertSame('This field must be between :min and :max kilobytes.', $this->trans('validation.between.file'));
        $this->assertSame('first name', $this->trans('validation.attributes.first_name'));
        $this->assertSame('last name', $this->trans('validation.attributes.last_name'));
        $this->assertSame('age', $this->trans('validation.attributes.age'));
        $this->assertSame('This field is required.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('First name must be a string.', $this->trans('validation.custom.first_name.string'));

        $this->artisanLangAdd(Locales::GERMAN, true);

        $this->assertSame('Alle Rechte vorbehalten.', $this->trans('All rights reserved.'));
        $this->assertSame('Forbidden', $this->trans('Forbidden'));
        $this->assertSame('Go to page', $this->trans('Go to page :page'));
        $this->assertSame('Hello!', $this->trans('Hello!'));

        $this->assertSame('These credentials do not match our records.', $this->trans('auth.failed'));
        $this->assertSame('The provided password is incorrect.', $this->trans('auth.password'));
        $this->assertSame('Too many login attempts. Please try again in :seconds seconds.', $this->trans('auth.throttle'));

        $this->assertSame('Next &raquo;', $this->trans('pagination.next'));
        $this->assertSame('&laquo; Previous', $this->trans('pagination.previous'));

        $this->assertSame('Dieses Feld muss akzeptiert werden.', $this->trans('validation.accepted'));
        $this->assertSame('The :attribute must be accepted when :other is :value.', $this->trans('validation.accepted_if'));
        $this->assertSame('The :attribute is not a valid URL.', $this->trans('validation.active_url'));
        $this->assertSame('Dieser Inhalt muss zwischen :min & :max Elemente haben.', $this->trans('validation.between.array'));
        $this->assertSame('Diese Datei muss zwischen :min & :max Kilobytes groß sein.', $this->trans('validation.between.file'));
        $this->assertSame('Vorname', $this->trans('validation.attributes.first_name'));
        $this->assertSame('last name', $this->trans('validation.attributes.last_name'));
        $this->assertSame('age', $this->trans('validation.attributes.age'));
        $this->assertSame('Dieses Feld muss ausgefüllt werden.', $this->trans('validation.custom.first_name.required'));
        $this->assertSame('First name must be a string.', $this->trans('validation.custom.first_name.string'));
    }
}
