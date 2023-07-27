@extends('layouts.app')

@section('content')
    <form action="{{ route('account.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Account Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
        </div>

        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" step="0.01" class="form-control" name="balance" id="balance" placeholder="Enter Balance" required>
        </div>

        <div class="form-group">
            <label for="currency">Currency</label>
            <select class="form-control" id="currency" name="currency_id" required>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">
                        {{ $currency->name }} ({{ $currency->symbol }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
