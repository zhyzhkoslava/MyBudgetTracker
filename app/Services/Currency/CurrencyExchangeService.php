<?php


namespace App\Services\Currency;


use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyExchangeService
{
    private $apiUrl = 'https://api.api-ninjas.com/v1/convertcurrency';

    public function convert($have, $want, $amount)
    {
        $cacheKey = "convert_{$have}_{$want}_{$amount}";

        return Cache::remember($cacheKey, now()->addHours(1), function () use ($have, $want, $amount) {
            try {
                $response = Http::get($this->apiUrl, [
                    'have'   => $have,
                    'want'   => $want,
                    'amount' => $amount,
                ]);

                if ($response->successful()) {
                    return $response->json();
                } else {
                    // Handle API error if necessary
                    throw new Exception('Unsuccessful response!');
                }
            } catch (\Exception $e) {
                // Handle exceptions, if any
                throw new Exception('Failed to get currencies');
            }
        });
    }
}
