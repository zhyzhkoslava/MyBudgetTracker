<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\Account\AccountService;
use App\Services\Transaction\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $transactionService;
    private $accountService;

    public function __construct(TransactionService $transactionService, AccountService $accountService)
    {
        $this->transactionService = $transactionService;
        $this->accountService = $accountService;
    }

    public function index()
    {
        $userId = Auth::user()->id;
        $transactions = $this->transactionService->index($userId);

        return view('transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $transaction = $this->transactionService->edit($transaction);
        $time = Carbon::parse($transaction->date);
        $userId = Auth::user()->id;
        $userAccounts = $this->accountService->showById($userId);

        return view('transaction.edit', compact('transaction', 'time','userAccounts'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $userData = $request->validated();
        $this->transactionService->update(
            $userData,
            $transaction
        );

        return view('transaction.show', compact('transaction'));
    }

    public function create()
    {
        $userId = Auth::user()->id;
        $userAccounts = $this->accountService->showById($userId);

        return view('transaction.create', compact('userAccounts'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->create(
            $request->validated()
        );

        return redirect()->route('transaction.index');
    }

    public function destroy(Transaction $transaction)
    {
        $this->transactionService->delete($transaction);

        return redirect()->route('transaction.index');
    }
}
