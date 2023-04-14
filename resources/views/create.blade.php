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
        @method('POST')
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
    $results = DB::select("select * from files where userId = $userId");
    ?>

    <div style="display: flex;flex-direction:column;margin-top:25px;gap:20px;">
        @foreach ($results as $file)
            <div style="display:flex;flex-direction:row;gap:20px;align-items:center">
                <img style="width:250px;" src="{{ asset('storage/uploads/' . $file->name) }}" />
                @if (Storage::exists('public/uploads/' . $file->name))
                    <h1><?php
                    echo decrypt($file->name); ?><h2>
                            <form action="{{ route('photos.destroy', $file->name) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">Delete</button>
                            </form>
                            <form action="{{ route('photos.download', $file->name) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-3">Download</button>
                            </form>
                @endif
            </div>
        @endforeach
    </div>
@endsection
