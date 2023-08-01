<?php


namespace App\Services\Currency;


use App\Repositories\Currency\CurrencyRepository;

class CurrencyService
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getCurrency()
    {
        return $this->currencyRepository->getCurrencies();
    }
}
