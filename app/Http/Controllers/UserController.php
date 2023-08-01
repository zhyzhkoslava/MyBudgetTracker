<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\User;
use App\Services\Currency\CurrencyService;
use App\Services\User\UserService;

class UserController extends Controller
{
    private $userService;
    private $currencyService;

    public function __construct(UserService $userService, CurrencyService $currencyService) {
        $this->userService = $userService;
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $userId = auth()->user()->id;

        $userInfo = $this->userService->index($userId);
        $currencies = $this->currencyService->getCurrency();
        $totalAmount = $this->userService->totalAmount($userId);

        return view('user.index', compact('userInfo', 'currencies', 'totalAmount'));
    }

    public function edit()
    {
        $userId = auth()->user()->id;
        $userInfo = $this->userService->index($userId);

        return view('user.edit', compact('userInfo'));
    }

    public function update(UpdateUserInfoRequest $request, User $user)
    {
        $this->userService->update(
            $request->validated(),
            $user
        );

        $userId = $request->user()->id;
        $userInfo = $this->userService->index($userId);
        $currencies = $this->currencyService->getCurrency();
        $totalAmount = $this->userService->totalAmount($userId);

        return view('user.index', compact('userInfo', 'currencies', 'totalAmount'));
    }
}
