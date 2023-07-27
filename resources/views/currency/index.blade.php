@extends('layouts.app')

@section('content')
    @foreach ($userData->currencies as $currency)
        <h1>Your default currency is {{ $currency->name . '(' . $currency->symbol . ')' }}</h1>
    @endforeach
    <form action="{{ route('currency.update', $userData->id)}}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="currency">Choose your default Currency!</label>
            <select class="form-control" id="currency" name="currency_id" required>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}" @if($userData->currency_id === $currency->id) selected @endif>
                        {{ $currency->name }} ({{ $currency->symbol }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <a href="{{ route('user') }}" class="btn btn-info">Back</a>
@endsection
