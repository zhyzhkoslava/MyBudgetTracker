<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;

        $transactions = Transaction::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $transaction = $transaction->load('account');
        $time = Carbon::parse($transaction->date);
        $userId = auth()->user()->id;
        $userAccounts = Account::query()
            ->with('currency')
            ->where('user_id', $userId)
            ->get();

        return view('transaction.edit', compact('transaction', 'time','userAccounts'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $data = $request->validated();
        $originalAmount = $transaction->amount;
        $transaction->update($data);

        // Check if the amount field was modified
        if ($transaction->amount !== $originalAmount) {

            $account = $transaction->account;
            $type = $data['type'];
            $amount = $data['amount'];
            $newAmount = ($type === 'income') ? ($account->balance + $amount) : ($account->balance - $amount);

            $account->update(['balance' => $newAmount]);
        }

        return view('transaction.show', compact('transaction'));
    }

    public function create()
    {
        $userId = auth()->user()->id;
        $userAccounts = Account::query()
            ->with('currency')
            ->where('user_id', $userId)
            ->get();

        return view('transaction.create', compact('userAccounts'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $data = $request->validated();

        Transaction::create($data);
        $account = Account::query()->find($data['account_id']);

        $type = $data['type'];
        $amount = $data['amount'];

        $newAmount = ($type === 'income') ? ($account->balance + $amount) : ($account->balance - $amount);

        $account->update(['balance' => $newAmount]);

        return redirect()->route('transaction.index');
    }

    public function destroy(Transaction $transaction)
    {
        $type = $transaction->type;
        $amount = $transaction->amount;

        $account = Account::query()->find($transaction->account_id);
        $newBalance = $type === 'income' ? $account->balance - $amount : $account->balance + $amount;
        $account->update(['balance' => $newBalance]);
        $transaction->delete();

        return redirect()->route('transaction.index');
    }
}
