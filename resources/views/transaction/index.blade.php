@extends('layouts.app')

@section('content')
    <h1>List of all Transactions!</h1>
    <a href="{{ route('transaction.create') }}" class="btn btn-info">Add Transaction</a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Type</th>
            <th scope="col">Amount</th>
            <th scope="col">Description</th>
            <th scope="col">Date</th>
            <th scope="col">Show</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <th>{{$transaction->type}}</th>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->description}}</td>
                <td>{{$transaction->date}}</td>
                <th><a href="{{ route('transaction.show', $transaction->id) }}" class="btn btn-warning">Show</a></th>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Add Pagination Links -->
    <div class="pagination pagination-sm">
        {{ $transactions->links() }}
    </div>

    <a href="{{ route('user') }}" class="btn btn-info">Back</a>
@endsection
