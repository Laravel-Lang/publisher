<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Decorators;

use Illuminate\Container\Attributes\Config;
use LaravelLang\Publisher\Contracts\Decorator;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Parser\Inline\HtmlInlineParser;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\AbstractStringContainer;
use League\CommonMark\Parser\InlineParserEngine;
use League\CommonMark\Reference\ReferenceMap;

use function array_merge;
use function config;
use function ltrim;
use function strlen;
use function substr;
use function trim;

class SmartPunctuationDecorator implements Decorator
{
    /** @var array<string, array{InlineParserEngine, Environment}> */
    protected array $parsers = [];

    /** @param array<array-key, mixed> $common */
    public function __construct(
        #[Config('localization_punctuation.common')]
        protected array $common,
    ) {}

    public function convert(string $locale, string $value): string
    {
        $content = trim($value);

        if ($content === '') {
            return $value;
        }

        [$parser, $environment] = $this->parsers[$locale] ??= $this->parser($locale);

        // Parse inlines directly so Markdown blocks cannot consume translation text.
        $document  = new Document;
        $paragraph = new Paragraph;
        $document->appendChild($paragraph);

        $parser->parse($content, $paragraph);
        $environment->dispatch(new DocumentParsedEvent($document));

        $prefixLength = strlen($value) - strlen(ltrim($value));
        $result       = substr($value, 0, $prefixLength);

        foreach ($paragraph->children() as $node) {
            if ($node instanceof AbstractStringContainer) {
                $result .= $node->getLiteral();
            }
        }

        return $result . substr($value, $prefixLength + strlen($content));
    }

    /** @return array{InlineParserEngine, Environment} */
    protected function parser(string $locale): array
    {
        $environment = new Environment([
            'smartpunct' => array_merge($this->common, config()->array('localization_punctuation.locales.' . $locale, [])),
        ]);

        $environment
            ->addExtension(new SmartPunctExtension)
            ->addInlineParser(new HtmlInlineParser);

        return [new InlineParserEngine($environment, new ReferenceMap), $environment];
    }
}
