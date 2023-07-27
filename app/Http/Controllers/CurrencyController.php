<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userData = User::with('currencies')->where('id', $userId)->first();
        $currencies = Currency::all();

        return view('currency.index', compact('userData', 'currencies'));
    }

    public function update(UpdateCurrencyRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);

        return redirect()->route('user');
    }
}
