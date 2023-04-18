@extends('layouts.master')

@section('content')
    <?php
    use Illuminate\Support\Facades\App;
    
    $environment = App::environment();
    dd(App::environment('local'));
    ?>
    <div>Profile</div>

    <form>


    </form>
@endsection
