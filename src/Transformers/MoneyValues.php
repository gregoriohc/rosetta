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
        $this->addDefaultConfig([
            'locale' => setlocale(LC_ALL, 0),
            'currency_code' => (new \NumberFormatter(setlocale(LC_ALL, 0), \NumberFormatter::CURRENCY))->getTextAttribute(\NumberFormatter::CURRENCY_CODE),
        ]);

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
        $isNegative = str_contains($value, '-');
        $valueToParse = str_replace([' ','+','-'], '', $value);

        try{
            /** @var \Money\Money $money */
            $money = $this->moneyParser->parse($valueToParse);
            $value = [
                'amount' => (int) (!$isNegative ? $money->getAmount() : -$money->getAmount()),
                'currency' => $money->getCurrency()->getCode(),
            ];
        } catch (\Exception $e) {
        }

        return $value;
    }
}