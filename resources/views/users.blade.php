@extends('layouts.master')

@section('content')
    @foreach ($users as $user)
        <div class="grid">
            <div>{{ $user }}</div>
            <div>{{ }}</div>
        </div>
    @endforeach
@endsection
