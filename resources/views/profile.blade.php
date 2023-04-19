@extends('layouts.master')

@section('content')
    @php
        $user = auth()->user();
    @endphp

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div style="display:flex;flex-direction:column;">
        <div>Profile</div>

        <form style="margin-top:20px;" action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns: 50% 50%;max-width:50%;margin-top:25px;">
                <div class="profile__section" style="display:grid;grid-template-columns: 30% 70%;">
                    <label for="email">Email</label>
                    <div class="col-md-6">

                        <div style="display:flex;flex-direction:column;width:200px;">
                            <input id="email" name="email" value=<?php echo $user->email; ?> />
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns: 50% 50%;max-width:50%;margin-top:25px;">
                <div class="profile__section" style="display:grid;grid-template-columns: 30% 70%;">
                    <label for="name">Name</label>
                    <div class="col-md-6">
                        <div style="display:flex;flex-direction:column;width:200px;">
                            <input id="name" name="name" value=<?php echo $user->name; ?> />
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div style="display:grid;grid-template-columns: 50% 50%;max-width:50%;margin-top:25px;">
                <div class="profile__section" style="display:grid;grid-template-columns: 30% 70%;">
                    <label for="last-name">Last name</label>
                    @if ($user->surname)
                        <input id="last-name" name="last-name" value=@php echo $user->surname; @endphp />
                    @else
                        <div style="display:flex;flex-direction:column;width:200px;">
                            <input id="last-name" name="last-name"placeholder="Enter last name" />
                            @if ($errors->has('last-name'))
                                <span class="text-danger">Last name field is required.</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit">Update profile</button>
        </form>
    </div>
@endsection
