@extends('layouts.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('password.update', ['token' => $token, 'email' => $email]) }}" method="POST">
        @csrf
        <h1>Enter new password</h1>
        <div>
            <label for="password">New password</label>
            <input type="password" id="password" name="password" placeholder="New password" required />
        </div>
        <div>
            <label for="password-confirmation">Confirm password</label>
            <input id="password-confirmation" type="password" name="password_confirmation" required />
        </div>

        <button type="submit">Confirm</button>

    </form>
@endsection
