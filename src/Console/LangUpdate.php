<?php

namespace Helldar\LaravelLangPublisher\Console;

use function array_map;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\File;
use function pathinfo;
use function resource_path;

class LangUpdate extends Command
{
    protected $signature = 'lang:update';

    protected $description = 'Updating installed localizations.';

    public function handle()
    {
        $this->call('lang:install', [
            'lang'    => $this->languages(),
            '--force' => true,
        ]);
    }

    protected function languages(): array
    {
        return array_map(function ($value) {
            return pathinfo($value, PATHINFO_FILENAME);
        }, $this->directories());
    }

    protected function directories(): array
    {
        return File::directories(
            resource_path('lang')
        );
    }
}
