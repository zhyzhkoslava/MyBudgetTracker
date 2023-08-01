<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use App\Models\Currency;
use App\Services\Account\AccountService;
use App\Services\Currency\CurrencyService;

class AccountController extends Controller
{
    private $accountService;
    private $currencyService;

    public function __construct(AccountService $accountService, CurrencyService $currencyService)
    {
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = $this->currencyService->getCurrency();

        return view('account.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountStoreRequest $request)
    {
        $userId = $request->user()->id;

        $this->accountService->store(
            $request->validated(),
            $userId
        );

        return redirect()->route('user');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $account = $this->accountService->show($account);

        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $data = $this->accountService->edit($account);
        $currencies = $this->currencyService->getCurrency();

        return view('account.edit', compact('data','currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        $this->accountService->update(
            $request->validated(),
            $account
        );

        return view('account.show', compact('account'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $this->accountService->delete(
            $account
        );

        return redirect()->route('user');
    }
}
