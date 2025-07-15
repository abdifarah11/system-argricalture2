@extends('layouts.app')

@section('content')
    <h2>Confirm Delete</h2>

    <p>Are you sure you want to delete user: <strong>{{ $user->fullname }}</strong> ({{ $user->email }})?</p>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-danger">Confirm Delete</button>
    </form>
@endsection
