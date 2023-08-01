<?php


namespace App\Services\Transaction;


use App\Repositories\Account\AccountRepository;
use App\Repositories\Transaction\TransactionRepository;

class TransactionService
{
    private $transactionRepository;
    private $accountRepository;

    public function __construct(TransactionRepository $transactionRepository, AccountRepository $accountRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;
    }

    public function index($userId)
    {
        return $this->transactionRepository->index($userId);
    }

    public function edit($transaction)
    {
        return $this->transactionRepository->edit($transaction);
    }

    public function update($userData, $transaction)
    {
        $this->updateAmountIfModified($transaction, $userData);

        return $this->transactionRepository->update($userData, $transaction);
    }

    public function updateAmountIfModified($transaction, $userData)
    {
        $originalAmount = $userData['amount'];
        if ($transaction->amount !== $originalAmount) {
            $delta = $originalAmount - $transaction->amount;

            $account = $transaction->account;
            $type = $userData['type'];

            $newAmount = ($type === 'income') ? ($account->balance + $delta) : ($account->balance - $delta);

            $this->accountRepository->update(['balance' => $newAmount], $account);
        }
    }

    public function create($userData)
    {
        $this->updateRelatedAccount($userData);

        return $this->transactionRepository->create($userData);
    }

    public function updateRelatedAccount($userData)
    {
        $account = $this->accountRepository->findByAccountId($userData['account_id']);

        $type = $userData['type'];
        $amount = $userData['amount'];

        $newAmount = ($type === 'income') ? ($account->balance + $amount) : ($account->balance - $amount);

        $this->accountRepository->update(['balance' => $newAmount], $account);
    }

    public function delete($transaction)
    {
        $this->updateRelatedAccount($transaction);

        $this->transactionRepository->delete($transaction);
    }

}
