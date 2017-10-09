<?php

namespace Ghc\Rosetta\Messages;

use DOMDocument;
use DOMNode;

class Xml extends Message
{
    /**
     * @return string
     */
    public function new()
    {
        return '<xml></xml>';
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
        $root->loadXML($this->get());

        return $this->domNodeToArray($root);
    }

    /**
     * @param array $data
     * @return self
     */
    public function fromArray($data)
    {
        return $this;
    }

    /**
     * @param DomNode $root
     * @return array
     */
    protected function domNodeToArray($root)
    {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if ($child->nodeType == XML_TEXT_NODE) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1
                        ? $result['_value']
                        : $result;
                }
            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->domNodeToArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = $this->domNodeToArray($child);
                }
            }
        }

        return $result;
    }
}