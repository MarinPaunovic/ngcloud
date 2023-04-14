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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="photo">Select photo:</label>
            <input type="file" class="form-control-file" id="photo" name="photo">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr>

    <h2>Uploaded photos:</h2>

    <?php
    $userId = auth()->user()->id;
    $results = DB::select("select * from files where $userId");
    ?>

    @foreach ($results as $file)
        @if (Storage::exists('public/uploads/' . $file->name))
            <h1>test</h1>
            <h1><?php
            $filename = basename($file->name);
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
            echo $withoutExt; ?><h2>
                    <form action="{{ route('photos.destroy', $filename) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-3">Delete</button>
                    </form>
        @endif
    @endforeach
@endsection
