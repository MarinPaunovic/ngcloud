@extends('layouts.master')

@section('content')
    <div class="home__wrapper">
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
        <div class="upload__wrapper">
            <div class="title__wrapper">
                <h1 class="title">Files</h1>
                <p class="description">Upload & download your files</p>
            </div>
            <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data" onchange="">
                @csrf
                @method('POST')
                <input type="file" id="photo" name="photo" class="hidden" onchange="this.form.submit()" />
                <label for="photo" class="btn btn-primary">New File</label>
            </form>
        </div>
        <div class="">
            <?php
            $userId = auth()->user()->id;
            $results = DB::select("select * from files where userId = $userId");
            ?>

            <div class="files__wrapper" style="display: flex;flex-direction:column;margin-top:25px;gap:20px;">
                <div class="grid">
                    <div></div>
                    <div>Name</div>
                    <div>Added</div>
                    <div>Size</div>
                    <div></div>
                </div>
                <div class="grid">
                    @foreach ($results as $file)
                        <div><img style="width:50px;" src="{{ asset('storage/uploads/' . $file->name) }}" /></div>
                        <div><?php echo decrypt($file->name); ?></div>
                        <div>05.04.2023</div>
                        <div>0.5MB</div>
                        <div class="buttons">
                            @if (Storage::exists('public/uploads/' . $file->name))
                                <form action="{{ route('photos.destroy', $file->name) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color:rgb(240,33,33);border-color:rgb(240, 33, 33)">
                                        <i class="fa fa-trash"></i></button>
                                </form>
                                <form action="{{ route('photos.download', $file->name) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i></button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
