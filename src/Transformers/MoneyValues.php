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
     * Boot Transformer.
     */
    protected function boot()
    {
        $defaultLocale = 'en_US';
        $numberFormatter = new \NumberFormatter($defaultLocale, \NumberFormatter::CURRENCY);

        $this->addDefaultConfig([
            'locale'        => $defaultLocale,
            'currency_code' => $numberFormatter->getTextAttribute(\NumberFormatter::CURRENCY_CODE),
        ]);

        $currencies = new ISOCurrencies();
        $intlParser = new IntlMoneyParser($numberFormatter, $currencies);
        $decimalParser = new DecimalMoneyParser($currencies);

        $this->moneyParser = new AggregateMoneyParser([
            $intlParser,
            $decimalParser,
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
                $data[$property] = $this->parseMoney($data[$property]);
            }
        }

        return $data;
    }

    /**
     * @param $value
     *
     * @return \Money\Money
     */
    private function parseMoney($value)
    {
        $isNegative = str_contains($value, '-');
        $valueToParse = str_replace([' ', '+', '-'], '', $value);

        try {
            /** @var \Money\Money $money */
            $money = $this->moneyParser->parse($valueToParse);
            $value = [
                'amount'   => (int) (!$isNegative ? $money->getAmount() : -$money->getAmount()),
                'currency' => $money->getCurrency()->getCode(),
            ];
        } catch (\Exception $e) {
        }

        return $value;
    }
}
