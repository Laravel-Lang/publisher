<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Decorators;

use Illuminate\Container\Attributes\Config;
use LaravelLang\Publisher\Contracts\Decorator;
use LaravelLang\Publisher\Punctuation\SmartExtension;
use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Util\HtmlFilter;
use Nette\Schema\Expect;

use function array_merge;
use function config;
use function is_string;

class SmartPunctuationDecorator implements Decorator
{
    protected array $decorators = [];

    public function __construct(
        #[Config('localization_punctuation.common')]
        protected array $common,
    ) {}

    public function convert(string $locale, bool|int|string $value): string
    {
        if (! is_string($value)) {
            return (string) $value;
        }

        return $this->decorator($locale)
            ->convert($value)
            ->getDocument()
            ->firstChild()
            ->firstChild()
            ->getLiteral();
    }

    protected function decorator(string $locale): ConverterInterface
    {
        return $this->decorators[$locale] ?? $this->converter($this->config($locale));
    }

    protected function converter(array $config): ConverterInterface
    {
        return new MarkdownConverter(
            $this->environment($config)->addExtension(new SmartExtension)
        );
    }

    protected function environment(array $config): Environment
    {
        return new Environment([
            'smartpunct' => $config,
            'html_input' => HtmlFilter::ALLOW,
            'renderer'   => [
                'block_separator' => Expect::string(),
                'inner_separator' => Expect::string(),
                'soft_break'      => Expect::string(),
            ],
        ]);
    }

    protected function config(string $locale): array
    {
        return array_merge($this->common, $this->localeConfig($locale));
    }

    protected function localeConfig(string $locale): array
    {
        return config('localization_punctuation.locales.' . $locale, []);
    }
}
