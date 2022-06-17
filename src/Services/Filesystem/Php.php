<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Filesystem;

use DragonCode\PrettyArray\Services\File;

class Php extends Base
{
    public function store(string $path, $content): string
    {
        $values = $this->sort($content);

        $content = $this->format($values);

        File::make($content)->store($path);

        return $path;
    }

    protected function format(array $items): string
    {
        if ($this->hasAlign()) {
            $this->formatter->setEqualsAlign();
        }

        return $this->formatter->raw($items);
    }
}
