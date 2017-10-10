<?php

namespace Ghc\Rosetta\Transformers;

use Money\Currencies\ISOCurrencies;
use Money\Parser\AggregateMoneyParser;
use Money\Parser\DecimalMoneyParser;
use Money\Parser\IntlMoneyParser;

class MoneyValues extends Transformer
{
    /**
     * @var AggregateMoneyParser
     */
    private $moneyParser;

    /**
     * Boot Transformer
     */
    protected function boot()
    {
        $this->config = array_merge([
            'locale' => 'en_US',
            'currency_code' => 'USD',
            'properties' => [],
        ], $this->config);

        $currencies = new ISOCurrencies();
        $numberFormatter = new \NumberFormatter($this->config['locale'], \NumberFormatter::CURRENCY);
        $intlParser = new IntlMoneyParser($numberFormatter, $currencies);
        $decimalParser = new DecimalMoneyParser($currencies);

        $this->moneyParser = new AggregateMoneyParser([
            $intlParser,
            $decimalParser,
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function transform($data)
    {
        foreach ($this->config['properties'] as $property) {
            if (isset($data[$property])) {
                $data[$property] = $this->parseMoney($data[$property]);
            }
        }
        
        return $data;
    }

    /**
     * @param $value
     * @return \Money\Money
     */
    private function parseMoney($value)
    {
        /** @var \Money\Money $money */
        $money = $this->moneyParser->parse($value);

        return [
            'amount' => (int) $money->getAmount(),
            'currency' => $money->getCurrency()->getCode(),
        ];
    }
}