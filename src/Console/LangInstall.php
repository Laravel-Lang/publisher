<?php

namespace Helldar\LaravelLangPublisher\Console;

use Helldar\Support\Facades\Arr;
use Helldar\Support\Facades\File;
use Helldar\Support\Facades\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Arr as ArrayIlluminate;
use Illuminate\Support\Str as StrIlluminate;

class LangInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:install {lang* : Lang files to copy} {--f|force : Force replace lang files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install lang files.';

    /**
     * @var string
     */
    protected $path_src;

    /**
     * @var string
     */
    protected $path_dst;

    /**
     * @var array
     */
    protected $lang;

    /**
     * @var bool
     */
    protected $force = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->path_src = $this->formatPath('vendor/caouecs/laravel-lang/src');
        $this->path_dst = $this->formatPath('resources/lang');

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->lang  = $this->argument('lang');
        $this->force = (bool) $this->option('force');

        foreach ($this->lang as $lang) {
            $this->processLang($lang);
        }
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function formatPath($value)
    {
        return Str::finish(\base_path($value));
    }

    /**
     * @param string $src
     * @param string $dst
     * @param string $filename
     */
    private function copy($src, $dst, $filename)
    {
        $action = \file_exists($dst) ? 'replaced' : 'copied';

        $is_validation = StrIlluminate::contains($filename, 'validation.php');

        if ($is_validation) {
            $this->copyValidations($src, $dst);
        } else {
            $this->copyOther($src, $dst);
        }

        $this->info("File {$filename} successfully {$action}");
    }

    /**
     * @param string $lang
     */
    private function processLang($lang)
    {
        $dir = $lang === 'en' ? '../script/en' : $lang;
        $src = Str::finish($this->path_src . $dir);
        $dst = Str::finish($this->path_dst . $lang);

        if (!\file_exists($src)) {
            $this->error("The directory for the \"{$lang}\" language was not found");

            return;
        }

        File::makeDirectory($dst);

        $this->processFile($src, $dst, $lang);
    }

    /**
     * Copy file to the new place.
     *
     * @param string $src
     * @param string $dst
     * @param string $lang
     */
    private function processFile($src, $dst, $lang)
    {
        $src_files = \scandir($src);

        foreach ($src_files as $file) {
            $src_file = ($src . $file);
            $dst_file = ($dst . $file);

            if (!\is_file($src_file) || !Str::endsWith($file, '.php')) {
                continue;
            }

            if ($this->force || !\file_exists($dst_file) || $this->confirm("Replace {$lang}/{$file} files?")) {
                $this->copy($src_file, $dst_file, ($lang . '/' . $file));
            }
        }
    }

    private function copyValidations($src, $dst)
    {
        $source = require $src;
        $target = \file_exists($dst) ? require $dst : [];

        $source_custom     = ArrayIlluminate::get($source, 'custom', []);
        $source_attributes = ArrayIlluminate::get($source, 'attributes', []);

        $target_custom     = ArrayIlluminate::get($target, 'custom', []);
        $target_attributes = ArrayIlluminate::get($target, 'attributes', []);

        $custom     = \array_merge($source_custom, $target_custom);
        $attributes = \array_merge($source_attributes, $target_attributes);

        $source = \array_merge($target, $source, \compact('custom', 'attributes'));

        Arr::store($source, $dst);
    }

    private function copyOther($src, $dst)
    {
        $source = require $src;
        $target = \file_exists($dst) ? require $dst : [];

        $source = \array_merge($target, $source);

        Arr::store($source, $dst);
    }
}
