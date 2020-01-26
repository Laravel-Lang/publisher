<?php

namespace Helldar\LaravelLangPublisher\Console;

use Illuminate\Console\Command;

class LangUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update lang files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lang = $this->getLangDirectories();

        $this->install($lang);
    }

    /**
     * Retrieving a Directory List.
     *
     * @return array
     */
    private function getLangDirectories()
    {
        $dir = scandir(resource_path('lang'));

        return array_filter($dir, function ($item) {
            return ! in_array($item, ['.', '..', 'vendor']);
        });
    }

    /**
     * Force language installation.
     *
     * @param string $lang
     */
    private function install($lang = 'en')
    {
        $this->call('lang:install', [
            'lang'    => $lang,
            '--force' => true,
        ]);
    }
}
