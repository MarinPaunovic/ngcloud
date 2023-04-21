@extends('layouts.master')

@section('content')
    @foreach ($users as $user)
        <div class="grid">
            <div>{{ $user->name }}</div>
            @foreach ($sizes as $size)
                @if (key($size) == $user->id)
                    <div>{{ $size[$user->id] }}</div>
                @endif
            @endforeach
        </div>
    @endforeach
@endsection
