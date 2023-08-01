<?php


namespace App\Repositories\Currency;


use App\Models\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    private $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function getCurrencies()
    {
        return $this->currency->get();
    }
}
