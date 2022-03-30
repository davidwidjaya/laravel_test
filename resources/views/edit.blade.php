@extends('layout.layout')
@section('section')
    <form method="POST" action="{{ route('user.update', ['user' => $user->id]) }}">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ $user->email }}" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
