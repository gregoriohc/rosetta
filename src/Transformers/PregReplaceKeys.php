<?php

namespace Ghc\Rosetta\Transformers;

class PregReplaceKeys extends Transformer
{
    /**
     * Boot Transformer
     */
    protected function boot()
    {
        $this->addDefaultConfig([
            'pattern' => '//',
            'replacement' => '',
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        return collect($data)->mapWithKeys(function($value, $key) {
            if (!count($this->config['properties']) || (count($this->config['properties']) && in_array($key, $this->config['properties'])))
            return [preg_replace($this->config['pattern'], $this->config['replacement'], $key) => !is_array($value) ? $value : $this->transform($value)];
        })->toArray();
    }
}