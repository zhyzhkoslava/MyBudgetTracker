<?php


namespace App\Repositories\Account;


use App\Models\Account;

class AccountRepository implements AccountRepositoryInterface
{
    private $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function store(array $userData): Account
    {
        return $this->account->create($userData);
    }

    public function show(Account $account)
    {
        return $account->load('currency', 'transactions');
    }

    public function edit(Account $account)
    {
        return $account->load('currency');
    }

    public function update(array $data, $account)
    {
        $account->update($data);

        return $account->update($data);
    }

    public function delete(Account $account): void
    {
        $account->delete();
    }

    public function showById($userId)
    {
        return $this->account
            ->query()
            ->with('currency')
            ->where('user_id', $userId)
            ->get();
    }

    public function findByAccountId($account_id)
    {
        return $this->account
            ->query()
            ->find($account_id);
    }
}
