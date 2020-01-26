<?php

namespace Helldar\LaravelLangPublisher\Console;

use DirectoryIterator;
use Helldar\PrettyArray\Services\File as PrettyFile;
use Helldar\PrettyArray\Services\Formatter;
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
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
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
     *
     * @return array
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     */
    protected function loadFile(string $filename): array
    {
        return PrettyFile::make()->load($filename);
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
     */
    protected function store(string $path, array $array)
    {
        ksort($array);

        $service = Formatter::make();
        $service->setKeyAsString();

        if (config('lang-publisher.alignment') === true) {
            $service->setEqualsAlign();
        }

        $content = $service->raw($array);

        PrettyFile::make($content)->store($path);
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
     */
    protected function processFile(string $src, string $dst, string $lang)
    {
        foreach ($this->files($src) as $file) {
            if ($file->isDir() || $file->getExtension() !== 'php') {
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
     */
    protected function copyValidations(string $src, string $dst)
    {
        $source = $this->loadFile($src);
        $target = file_exists($dst) ? $this->loadFile($dst) : [];

        $source_custom     = ArrayIlluminate::get($source, 'custom', []);
        $source_attributes = ArrayIlluminate::get($source, 'attributes', []);

        $target_custom     = ArrayIlluminate::get($target, 'custom', []);
        $target_attributes = ArrayIlluminate::get($target, 'attributes', []);

        $custom     = array_merge($source_custom, $target_custom);
        $attributes = array_merge($source_attributes, $target_attributes);

        $source = array_merge($target, $source, compact('custom', 'attributes'));

        $this->store($dst, $source);
    }

    /**
     * Merging arrays.
     *
     * @param string $src
     * @param string $dst
     *
     * @throws \Helldar\PrettyArray\Exceptions\FileDoesntExistsException
     */
    protected function copyOther(string $src, string $dst)
    {
        $source = $this->loadFile($src);
        $target = file_exists($dst) ? $this->loadFile($dst) : [];

        $source = array_merge($target, $source);

        $this->store($dst, $source);
    }
}
