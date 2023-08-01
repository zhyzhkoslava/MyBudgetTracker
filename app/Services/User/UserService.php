<?php


namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Currency\CurrencyExchangeService;
use App\Services\Currency\CurrencyService;
use Illuminate\Support\Facades\Hash;


final class UserService
{
    private $userRepository;
    private $currencyService;
    private $currencyExchangeService;

    public function __construct(UserRepository $userRepository, CurrencyExchangeService $currencyExchangeService, CurrencyService $currencyService)
    {
        $this->userRepository = $userRepository;
        $this->currencyExchangeService = $currencyExchangeService;
        $this->currencyService = $currencyService;
    }

    public function index(int $userId)
    {
        return $this->userRepository->getUserInfo($userId);
    }

    public function update(array $userData, User $user)
    {
        $this->prepareUpdateData($userData);

        return $this->userRepository->update($user, $userData);
    }

    private function prepareUpdateData(array &$userData): void
    {
        if ( $userData['name'] == null ){
            unset($userData['name']);
        }
        if ( $userData['password'] == null ){
            unset($userData['password']);
        }
        if (isset($userData['password'])){
            $userData['password'] = Hash::make($userData['password']);
        }
    }

    public function totalAmount(int $userId): float
    {
        $userInfo = $this->index($userId);

        $totalAmount=0;
        foreach ($userInfo->accounts as $account)
        {
            if ($account->currency_id !== $userInfo->currency_id)
            {
                $haveCurrency = $this->currencyService->getCurrency()->firstWhere('id', $account->currency_id)->name;
                $wantCurrency = $this->currencyService->getCurrency()->firstWhere('id', $userInfo->currency_id)->name;
                $convertedAmount = $this->currencyExchangeService->convert($haveCurrency, $wantCurrency, $account->balance);
                $totalAmount += $convertedAmount['new_amount'];
            } else {
                $totalAmount += $account->balance;
            }
        }

        return $totalAmount;
    }
}
