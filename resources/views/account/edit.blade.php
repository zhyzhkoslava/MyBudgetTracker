@extends('layouts.app')

@section('content')
    <h1>Edit Account</h1>
    <form action="{{ route('account.update', $data->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Account Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}" required>
        </div>

        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" step="0.01" class="form-control" name="balance" id="balance" value="{{ $data->balance }}" required>
        </div>

        <div class="form-group">
            <label for="currency">Currency</label>
            <select class="form-control" id="currency" name="currency_id" required disabled>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}" @if ($currency->id === $data->currency->id) selected @endif>
                        {{ $currency->name }} ({{ $currency->symbol }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
