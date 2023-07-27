@extends('layouts.app')

@section('content')
    <h1>Edit Transaction</h1>
    <form action="{{ route('transaction.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="date">Transaction Date</label>
            <input type="date" class="form-control" name="date" id="date" value="{{$time->format('Y-m-d')}}" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" required>
                <option value="">Select Type</option>
                <option value="income" @if($transaction->type === 'income') selected @endif>Income</option>
                <option value="expense" @if($transaction->type === 'expense') selected @endif>Expense</option>
            </select>
        </div>

        <div class="form-group">
            <label for="account_id">Account</label>
            <select class="form-control" name="account_id" id="account_id" required>
                @foreach ($userAccounts as $account)
                    <option value="{{ $account->id }}" @if($transaction->account_id === $account->id) selected @endif>{{ $account->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" value="{{ $transaction->amount}}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" value="{{ $transaction->description}}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
