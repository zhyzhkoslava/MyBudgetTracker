@extends('layouts.app')

@section('content')
    <table class="table">
        <h1>Hi <b>{{$userInfo->name}}</b>!</h1>
        <h3>You have {{ $userInfo->accounts->count()}} account(s)</h3>
        <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('account.create') }}" class="btn btn-info">Add Account</a>
        <a href="{{ route('transaction.index') }}" class="btn btn-success">Transactions</a>
        <a href="{{ route('currency.index') }}" class="btn btn-warning">Currencies</a>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Balance</th>
                <th scope="col">Currency</th>
                <th scope="col">Symbol</th>
                <th scope="col">Show</th>
            </tr>
            </thead>
            <tbody>
            @php
                $number=0;
            @endphp
            @foreach($userInfo->accounts as $account)
                <tr>
                    <th scope="row">{{++$number}}</th>
                    <th>{{$account->name}}</th>
                    <td>{{$account->balance}}</td>
                    <td>{{$account->currency->name}}</td>
                    <td>{{$account->currency->symbol}}</td>
                    <th><a href="{{ route('account.show', $account->id) }}" class="btn btn-primary">Show</a></th>
                </tr>
            @endforeach
        </tbody>
    </table>
    @foreach ($userInfo->currencies as $currency)
        <h1>Your default currency is {{ $currency->name . '(' . $currency->symbol . ')' }}</h1>
    @endforeach
    <div class="card">
        <h1>Summary Balance of All Accounts in Default currency: <span>{{$totalAmount}}</span></h1>
    </div>
@endsection
