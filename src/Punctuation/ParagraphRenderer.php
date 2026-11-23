<?php

declare(strict_types=1);

namespace LaravelLang\Publisher\Punctuation;

use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Xml\XmlNodeRendererInterface;

class ParagraphRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        Paragraph::assertInstanceOf($node);

        return $childRenderer->renderNodes($node->children());
    }

    public function getXmlTagName(Node $node): string
    {
        return 'paragraph';
    }

    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
