<?php

namespace Ghc\Rosetta\Messages;

use DOMDocument;

class Html extends Xml
{
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
        libxml_use_internal_errors(true);
        $root = new DOMDocument();
        $root->preserveWhiteSpace = false;
        $root->loadHTML($this->getData());

        return $this->domNodeToArray($root);
    }
}
