<?php

namespace Helldar\LaravelLangPublisher\Console;

use function compact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function resource_path;

class LangUninstall extends Command
{
    protected $signature = 'lang:uninstall {lang* : Lang files to uninstall}';

    protected $description = 'Uninstall localizations.';

    protected $result = [];

    public function handle()
    {
        $this->uninstall(
            (array) $this->argument('lang')
        );

        $this->showResult();
    }

    protected function uninstall(array $languages): void
    {
        foreach ($languages as $language) {
            $result = File::deleteDirectory(
                resource_path('lang' . DIRECTORY_SEPARATOR . $language)
            );

            $this->pushResult($language, $result);
        }
    }

    protected function pushResult(string $language, bool $result)
    {
        $status = $result ? 'uninstalled' : 'error';

        $this->result[] = compact('language', 'status');
    }

    protected function showResult(): void
    {
        if (empty($this->result)) {
            $this->info('No uninstalled localizations.');

            return;
        }

        $this->table(['Locale', 'Status'], $this->result);
    }
}
