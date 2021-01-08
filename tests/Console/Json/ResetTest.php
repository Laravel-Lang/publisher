<?php

namespace Tests\Console\Json;

use Helldar\LaravelLangPublisher\Services\Processors\ResetJson;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

final class ResetTest extends TestCase
{
    protected $processor = ResetJson::class;

    protected $is_json = true;

    public function testWithoutFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));

        $this->artisan('lang:reset', ['--json' => true])
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        Lang::setLoaded([]);

        $this->assertSame('Foo', Lang::get('Foo'));
        $this->assertSame('Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));
    }

    public function testWithFullOption()
    {
        $this->copyFixtures();

        $this->assertSame('This is Foo', Lang::get('Foo'));
        $this->assertSame('This is Bar', Lang::get('Bar'));
        $this->assertSame('This is Baz', Lang::get('Baz'));

        Lang::setLoaded([]);

        $this->artisan('lang:reset', ['--json' => true, '--full' => true])
            ->expectsConfirmation('Do you want to reset all localizations?', 'yes');

        $this->assertSame('Foo', Lang::get('Foo'));
        $this->assertSame('Bar', Lang::get('Bar'));
        $this->assertSame('Baz', Lang::get('Baz'));
    }
}
