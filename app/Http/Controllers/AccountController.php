<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::all();

        return view('account.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountStoreRequest $request)
    {
        $userId = auth()->user()->id;

        $data = $request->validated();
        $data['user_id'] = $userId;

        Account::firstOrCreate($data);

        return redirect()->route('user');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $account = $account->load('currency', 'transactions');

        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $data = $account->load('currency');
        $currencies = Currency::all();

        return view('account.edit', compact('data','currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        $data = $request->validated();
        $account->update($data);

        return view('account.show', compact('account'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('user');
    }
}
