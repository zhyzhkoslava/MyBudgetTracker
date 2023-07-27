@extends('layouts.app')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Type</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{$transaction->type}}</th>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->date}}</td>
                <th><a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-warning">Edit</a></th>
                <td>
                    <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('transaction.index') }}" class="btn btn-info">Back</a>
@endsection
