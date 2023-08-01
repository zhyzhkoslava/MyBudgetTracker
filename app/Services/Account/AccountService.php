<?php


namespace App\Services\Account;


use App\Models\Account;
use App\Repositories\Account\AccountRepository;

class AccountService
{
    private $accountRepository;

    public function __construct(AccountRepository $currencyRepository)
    {
        $this->accountRepository = $currencyRepository;
    }

    public function store(array $userData, int $userId)
    {
        $userData['user_id'] = $userId;

        return $this->accountRepository->store($userData);
    }

    public function show($account)
    {
        return $this->accountRepository->show($account);
    }

    public function edit($account)
    {
        return $this->accountRepository->edit($account);
    }

    public function update($userData, $account)
    {
        return $this->accountRepository->update($userData, $account);
    }

    public function delete($account)
    {
        $this->accountRepository->delete($account);
    }

    public function showById($userId)
    {
        return $this->accountRepository->showById($userId);
    }
}
