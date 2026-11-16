<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Console;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use LaravelLang\Filesystem\Filesystem;
use LaravelLang\Publisher\Collectors\PluginCollector;

use LaravelLang\Publisher\Collectors\SourceCollector;

use function Laravel\Prompts\task;

#[Signature('lang:update')]
#[Description('Updating installed localizations')]
final class UpdateCommand extends Command
{
    public function __invoke(
        Filesystem $filesystem,
        PluginCollector $pluginCollector,
        SourceCollector $sourceCollector,
    ): int {
        task('Find plugins', function () use ($pluginCollector, &$plugins) {
            $plugins = $pluginCollector->find();
        });

        task('Collecting source', function () use ($sourceCollector, $plugins, &$source) {
            $source = $sourceCollector->all($plugins);
        });

        return self::SUCCESS;
    }
}
