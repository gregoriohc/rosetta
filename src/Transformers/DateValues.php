<?php

namespace Ghc\Rosetta\Transformers;

use Carbon\Carbon;

class DateValues extends Transformer
{
    /**
     * Boot Transformer.
     */
    protected function boot()
    {
        $this->addDefaultConfig([
            'locale'   => setlocale(LC_ALL, 0),
            'timezone' => date_default_timezone_get(),
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function transform($data)
    {
        foreach ($this->config['properties'] as $property) {
            if (isset($data[$property])) {
                $data[$property] = $this->parseDate($data[$property]);
            }
        }

        return $data;
    }

    /**
     * @param $value
     *
     * @return \Money\Money
     */
    private function parseDate($value)
    {
        try {
            $value = (new Carbon($value, $this->config['timezone']))->toIso8601String();
        } catch (\Exception $e) {
        }

        return $value;
    }
}
