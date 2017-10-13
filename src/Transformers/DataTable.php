<?php

namespace Ghc\Rosetta\Transformers;

use Ghc\Rosetta\Item;

class DataTable extends Transformer
{
    /**
     * Boot Transformer
     */
    protected function boot()
    {
        $this->addDefaultConfig([
            'hasHeader' => true,
            'useHeaderAsIndex' => true,
            'ignoreHeader' => false,
            'orientation' => 'vertical',
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        if ('horizontal' == $this->config['orientation']) {
            $data = (new Item($data, [new TransposeValues]))->toArray();
        }

        if ($this->config['hasHeader']) {
            $header = array_shift($data);

            if ($this->config['useHeaderAsIndex']) {
                $data = collect($data)->map(function ($row) use ($header) {
                    return collect($row)->mapWithKeys(function ($column, $index) use ($header) {
                        return [$header[$index] => $column];
                    });
                })->toArray();
            } elseif (!$this->config['ignoreHeader']) {
                array_unshift($data, $header);
            }
        }

        return $data;
    }
}