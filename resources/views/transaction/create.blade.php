@extends('layouts.app')

@section('content')
    <h1>Create Transaction</h1>
    <form action="{{ route('transaction.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="date">Transaction Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" required>
                <option value="">Select Type</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>

        <div class="form-group">
            <label for="account">Account</label>
            <select class="form-control" name="account_id" id="account" required>
                <option value="">Select Account</option>

                @if ($userAccounts->isEmpty())
                    <option value="" disabled>No accounts available</option>
                @else
                    @foreach ($userAccounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name .' - '. $account->balance . '(' . $account->currency->name.$account->currency->symbol .')' }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
