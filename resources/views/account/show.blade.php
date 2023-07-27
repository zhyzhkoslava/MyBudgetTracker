@extends('layouts.app')

@section('content')
    <h1>Account</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Balance</th>
            <th scope="col">Currency</th>
            <th scope="col">Symbol</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{$account->name}}</th>
                <td>{{$account->balance}}</td>
                <td>{{$account->currency->name}}</td>
                <td>{{$account->currency->symbol}}</td>
                <th><a href="{{ route('account.edit', $account->id) }}" class="btn btn-warning">Edit</a></th>
                <th>
                @if ($account->transactions->count() > 0)
                    <button type="submit" class="btn btn-danger" disabled>Delete</button>
                @else
                    <form action="{{ route('account.destroy', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
                </th>
            </tr>
        </tbody>
    </table>

    <h1>Transactions</h1>
    @if ($account->transactions->count() > 0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Show</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($account->transactions()->orderBy('created_at', 'desc')->get() as $transaction)
                <tr>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>
                        <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No transactions found for this account.</p>
    @endif
    <a href="{{ route('user') }}" class="btn btn-info">Back</a>
@endsection
