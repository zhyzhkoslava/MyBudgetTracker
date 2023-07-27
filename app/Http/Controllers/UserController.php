<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isFalse;

class UserController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $userInfo = User::with('accounts','currencies')->where('id', $userId)->first();
        $accounts = $userInfo->accounts;
        $accountAmount = $userInfo->accounts->count();
        $currencyService = app()->get('currency');
        $currencies = Currency::all();

        $totalAmount=0;
        foreach ($accounts as $account)
        {
            if ($account->currency_id !== $userInfo->currency_id)
            {
                $haveCurrency = $currencies->firstWhere('id', $account->currency_id)->name;
                $wantCurrency = $currencies->firstWhere('id', $userInfo->currency_id)->name;
                $convertedAmount = $currencyService->getCurrencies($haveCurrency, $wantCurrency, $account->balance);
                $totalAmount += $convertedAmount['new_amount'];
            } else {
                $totalAmount += $account->balance;
            }
        }

        return view('user.index', compact('userInfo', 'accountAmount', 'accounts', 'currencies', 'totalAmount'));
    }

    public function edit()
    {
        $userId = auth()->user()->id;
        $userInfo = User::findOrFail($userId);

        return view('user.edit', compact('userInfo'));
    }

    public function update(UpdateUserInfoRequest $request, User $user)
    {
        $data = $request->validated();
        if ( $data['name'] == null ){
            unset($data['name']);
        }
        if ( $data['password'] == null ){
            unset($data['password']);
        }
        if (isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        $userId = auth()->user()->id;
        $userInfo = User::with('accounts')->findOrFail($userId);
        $accounts = $userInfo->accounts();
        $accountAmount = $userInfo->accounts->count();

        return view('user.index', compact('userInfo', 'accountAmount', 'accounts'));
    }
}
