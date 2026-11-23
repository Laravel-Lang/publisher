<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Punctuation;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\CommonMark\Extension\SmartPunct\DashParser;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use League\CommonMark\Extension\SmartPunct\Quote;
use League\CommonMark\Extension\SmartPunct\QuoteParser;
use League\CommonMark\Extension\SmartPunct\QuoteProcessor;
use League\CommonMark\Extension\SmartPunct\ReplaceUnpairedQuotesListener;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Renderer\Block\DocumentRenderer;
use League\CommonMark\Renderer\Inline\TextRenderer;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;

class SmartExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema(
            'smartpunct',
            Expect::structure([
                'double_quote_opener' => Expect::string(Quote::DOUBLE_QUOTE_OPENER),
                'double_quote_closer' => Expect::string(Quote::DOUBLE_QUOTE_CLOSER),
                'single_quote_opener' => Expect::string(Quote::SINGLE_QUOTE_OPENER),
                'single_quote_closer' => Expect::string(Quote::SINGLE_QUOTE_CLOSER),
            ])
        );
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new QuoteParser, 10)
            ->addInlineParser(new DashParser)
            ->addInlineParser(new EllipsesParser)
            ->addDelimiterProcessor(
                QuoteProcessor::createDoubleQuoteProcessor(
                    $environment->getConfiguration()->get('smartpunct/double_quote_opener'),
                    $environment->getConfiguration()->get('smartpunct/double_quote_closer')
                )
            )
            ->addDelimiterProcessor(
                QuoteProcessor::createSingleQuoteProcessor(
                    $environment->getConfiguration()->get('smartpunct/single_quote_opener'),
                    $environment->getConfiguration()->get('smartpunct/single_quote_closer')
                )
            )
            ->addEventListener(DocumentParsedEvent::class, new ReplaceUnpairedQuotesListener)
            ->addRenderer(Document::class, new DocumentRenderer)
            ->addRenderer(Paragraph::class, new ParagraphRenderer)
            ->addRenderer(Text::class, new TextRenderer);
    }
}
