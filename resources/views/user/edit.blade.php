@extends('layouts.app')

@section('content')
    <form action="{{route('user.update', $userInfo->id)}}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter New Name" >
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Enter Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter New Password" >
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Enter Password Confirmation</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="Enter New Password Confirmation" >
            @error('password_confirmation')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
    <a href="{{ route('user') }}" class="btn btn-primary">Back</a>
@endsection
