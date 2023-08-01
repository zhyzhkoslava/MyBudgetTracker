<?php


namespace App\Repositories\Transaction;


use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function index($userId)
    {
        return $this->transaction
            ->query()
            ->whereHas('account', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function edit($transaction)
    {
        return $transaction->load('account');
    }

    public function update(array $userData, Transaction $transaction)
    {
        $transaction->update($userData);

        return $transaction->fresh();
    }

    public function create($userData)
    {
        return $this->transaction->query()->create($userData);
    }

    public function delete($transaction):void
    {
        $transaction->delete();
    }
}
