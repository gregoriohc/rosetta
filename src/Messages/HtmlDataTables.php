<?php

namespace Ghc\Rosetta\Messages;

use Ghc\Rosetta\Item;
use Ghc\Rosetta\Transformers\DataTable;
use Symfony\Component\DomCrawler\Crawler;

class HtmlDataTables extends Xml
{
    /**
     * Boot Transformer
     */
    protected function boot()
    {
        $this->addDefaultConfig([
            'selector' => 'table',
            'hasHeader' => true,
            'useHeaderAsIndex' => true,
            'ignoreHeader' => false,
            'orientation' => 'vertical',
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

        return $crawler->filter($this->getConfig()['selector'])->each(function ($table) {
            $rows = [];
            try {
                /** @var Crawler $table */
                $rows = $table->filter('tr')->each(function ($row) {
                    /** @var Crawler $row */
                    return $row->filter('th,td')->each(function ($column) {
                        /** @var Crawler $column */
                        return trim($column->text());
                    });
                });

                $rows = (new Item($rows, [new DataTable($this->getConfig())]))->toArray();
            } catch (\Exception $e) {
            }

            return $rows;
        });
    }
}