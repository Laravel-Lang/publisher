<?php

/**
 * This file is part of the "Laravel-Lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/Laravel-Lang/publisher
 */

declare(strict_types=1);

namespace LaravelLang\Publisher\Services\Converters\Text;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\MarkdownConverter;

class SmartPunctuationDecorator extends BaseDecorator
{
    protected array $decorators = [];

    public function convert(string $locale, string $value): string
    {
        $value = strip_tags($this->decorate($locale, $value));

        return rtrim($value, PHP_EOL);
    }

    protected function decorate(string $locale, string $value): string
    {
        return $this->decorator($locale)->convert($value)->getContent();
    }

    protected function decorator(string $locale)
    {
        if (isset($this->decorators[$locale])) {
            return $this->decorators[$locale];
        }

        return $this->decorators[$locale] = $this->converter(
            $this->config->smartPunctuationConfig($locale)
        );
    }

    protected function converter(array $smartpunct): ConverterInterface
    {
        return new MarkdownConverter(
            $this->environment($smartpunct)->addExtension(new SmartPunctExtension())
        );
    }

    protected function environment(array $smartpunct): Environment
    {
        return new Environment([
            'smartpunct' => $smartpunct,
            'html_input' => 'escape',
        ]);
    }
}
