<?php

namespace Ghc\Rosetta\Messages;

use Symfony\Component\DomCrawler\Crawler;

class HtmlElements extends Xml
{
    /**
     * Boot Transformer
     */
    protected function boot()
    {
        $this->addDefaultConfig([
            'selector' => 'html',
        ]);
    }

    /**
     * @return string
     */
    public function newData()
    {
        return '<html></html>';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $crawler = new Crawler((string)$this->getData());

        return $crawler->filter($this->getConfig()['selector'])->each(function ($element) {
            /** @var Crawler $element */
            return $this->domNodeToArray($element->getNode(0));
        });
    }
}