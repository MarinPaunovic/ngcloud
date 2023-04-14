@extends('layouts.master')

@section('content')
    <?php
    use Illuminate\Support\Facades\Storage;
    
    $results = DB::select('select * from users');
    $result1 = DB::select('select * from files');
    
    ?>


    <form method="post" action={{ 'delete' }}>
        <input type="submit" name="button1" class="button" value="Button1" />
    </form>

    <img src="{{ asset('upload/file.jpg') }}" alt="description of myimage">

    <div class="container mt-5">
        <form action="" method="post" enctype="multipart/form-data">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>
                        {{ $message }}
                    </strong>
                </div>
            @endif
            <h3 class="text-center mb-5">Upload File in Laravel</h3>
            @csrf
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload Files
            </button>
        </form>
    </div>
@endsection
