<?php

namespace Helldar\LaravelLangPublisher\Console;

use DirectoryIterator;
use Helldar\PrettyArray\Contracts\Caseable;
use Helldar\PrettyArray\Services\File;
use Helldar\PrettyArray\Services\Formatter;
use Helldar\Support\Facades\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
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
     * @var array
     */
    protected $exclude = [];

    /** @var int */
    protected $case;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->path_src = $this->formatPath('vendor/caouecs/laravel-lang/src');
        $this->path_dst = $this->formatPath('resources/lang');

        $this->exclude = config('lang-publisher.exclude', []);
        $this->case    = config('lang-publisher.case', Caseable::NO_CASE);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
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
     * Loading existence check file.
     *
     * @param string $filename
     * @param bool $return_empty
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     *
     * @return array
     */
    protected function loadFile(string $filename, bool $return_empty = false): array
    {
        if ($return_empty && ! file_exists($filename)) {
            return [];
        }

        return File::make()->load($filename);
    }

    /**
     * Getting a list of files in a directory
     *
     * @param string $path
     *
     * @return \DirectoryIterator
     */
    protected function files(string $path): DirectoryIterator
    {
        return new DirectoryIterator($path);
    }

    /**
     * Saving the resulting array to a file.
     *
     * @param string $path
     * @param array $array
     *
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function store(string $path, array $array)
    {
        ksort($array);

        $service = Formatter::make();
        $service->setKeyAsString();
        $service->setCase($this->case);

        if (config('lang-publisher.alignment') === true) {
            $service->setEqualsAlign();
        }

        $content = $service->raw($array);

        File::make($content)->store($path);
    }

    /**
     * Verifying the trailing character in the path.
     *
     * @param string $value
     *
     * @return string
     */
    protected function formatPath(string $value): string
    {
        return Str::finish(base_path($value));
    }

    /**
     * Copy files with the start of the union.
     *
     * @param string $src
     * @param string $dst
     * @param string $filename
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function copy(string $src, string $dst, string $filename)
    {
        $action = file_exists($dst) ? 'replaced' : 'copied';

        $is_validation = StrIlluminate::contains($filename, 'validation.php');

        if ($is_validation) {
            $this->copyValidations($src, $dst);
        } else {
            $this->copyOther($src, $dst);
        }

        $this->info("File {$filename} successfully {$action}");
    }

    /**
     * Language test and preparation for integration.
     *
     * @param string $lang
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function processLang(string $lang)
    {
        $dir = $lang === 'en' ? '../script/en' : $lang;
        $src = Str::finish($this->path_src . $dir);
        $dst = Str::finish($this->path_dst . $lang);

        if (! file_exists($src)) {
            $this->error("The directory for the \"{$lang}\" language was not found");

            return;
        }

        $this->processFile($src, $dst, $lang);
    }

    /**
     * Copy file to the new place.
     *
     * @param string $src
     * @param string $dst
     * @param string $lang
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function processFile(string $src, string $dst, string $lang)
    {
        foreach ($this->files($src) as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php' || StrIlluminate::contains($file->getFilename(), '-inline')) {
                continue;
            }

            $filename = $file->getFilename();
            $src_file = $file->getRealPath();
            $dst_file = $dst . $file->getFilename();

            if (
                $this->force ||
                ! file_exists($dst_file) ||
                $this->confirm("Replace {$lang}/{$filename} file?")
            ) {
                $this->copy($src_file, $dst_file, ($lang . '/' . $filename));
            }
        }
    }

    /**
     * Merging Validator Arrays.
     *
     * @param string $src
     * @param string $dst
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function copyValidations(string $src, string $dst)
    {
        $source = $this->loadFile($src);
        $target = $this->loadFile($dst, true);

        $source_custom     = Arr::get($source, 'custom', []);
        $source_attributes = Arr::get($source, 'attributes', []);

        $target_custom     = Arr::get($target, 'custom', []);
        $target_attributes = Arr::get($target, 'attributes', []);

        $excluded_target     = $this->excluded($dst, $target);
        $excluded_custom     = $this->excluded($dst, $target_custom);
        $excluded_attributes = $this->excluded($dst, $target_attributes);

        $custom     = array_merge($source_custom, $target_custom, $excluded_custom);
        $attributes = array_merge($source_attributes, $target_attributes, $excluded_attributes);

        $source = array_merge($target, $source, $excluded_target, compact('custom', 'attributes'));

        $this->store($dst, $source);
    }

    /**
     * Merging arrays.
     *
     * @param string $src
     * @param string $dst
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     * @throws \Helldar\PrettyArray\Exceptions\UnknownCaseTypeException
     */
    protected function copyOther(string $src, string $dst)
    {
        $source = $this->loadFile($src);
        $target = $this->loadFile($dst, true);

        $excluded = $this->excluded($dst, $target);

        $source = array_merge($target, $source, $excluded);

        $this->store($dst, $source);
    }

    /**
     * Getting excluded keys.
     *
     * @param string $filename
     * @param array $array
     *
     * @return array
     */
    protected function excluded(string $filename, array $array): array
    {
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        $keys     = $this->exclude[$filename] ?? [];

        return Arr::only($array, $keys);
    }
}
