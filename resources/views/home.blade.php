@extends('layouts.master')

@section('content')
    <?php
    $isAdmin = auth()->user()->role === 'admin';
    $userId = auth()->user()->id;
    ?>
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
            <div class="just__wrapper">
                <div class="title__wrapper">
                    <h1 class="title">Files</h1>
                    <p class="description">Upload & download your files</p>
                </div>
                <div> <?php
                $spaceTaken = 0;
                foreach ($files as $file) {
                    $spaceTaken = $spaceTaken + number_format($file->file_size / 1024 / 1024, 2);
                }
                
                echo number_format(3 - $spaceTaken / 1000, 2);
                ?> / 3 GB available</div>
            </div>
            <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="file" id="file" name="file" class="hidden" onchange="this.form.submit()" />
                <label for="file" class="btn btn-primary">New File</label>
            </form>

            <div>

                <div class="files__wrapper" style="display: flex;flex-direction:column;margin-top:25px;gap:20px;">
                    <div class="<?php if ($isAdmin) {
                        echo 'grid grid__admin';
                    } else {
                        echo 'grid';
                    }
                    ?>">
                        <div></div>
                        <div>Name</div>
                        <div>Added</div>
                        <div>Size</div>
                        @if ($isAdmin)
                            <div>Added by</div>
                        @endif
                        <div></div>
                    </div>
                    <div class="<?php if ($isAdmin) {
                        echo 'grid grid__admin';
                    } else {
                        echo 'grid';
                    }
                    ?>">
                        @foreach ($files as $file)
                            <?php
                            $name = decrypt($file->name);
                            $fileExtension = substr($name, strpos($name, '.') + 1);
                            ?>

                            @switch($fileExtension)
                                @case($fileExtension === 'png' || $fileExtension === 'jpeg' || $fileExtension === 'jpg' || $fileExtension === 'avif')
                                    <div><i class="fa fa-picture-o"></i></div>
                                @break

                                @case('pdf')
                                    <div><i class="fa fa-file-pdf-o" aria-hidden="true"></i></div>
                                @break

                                @case('xdoc')
                                    <div>xdoc image</div>
                                @break

                                @case('xlsx')
                                    <div>xlsx image</div>
                                @break
                            @endswitch

                            <div><?php echo $name; ?></div>
                            <div><?php echo $file->created_at; ?></div>
                            <div><?php
                            $size_mb = number_format($file->file_size / 1024 / 1024, 2);
                            
                            echo $size_mb . 'MB'; ?></div>

                            @if ($isAdmin)
                                <div>
                                    @php
                                        $name = DB::table('users')
                                            ->where('id', '=', $file->userId)
                                            ->get('name');
                                        
                                        echo $name[0]->name;
                                    @endphp</div>
                            @endif
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
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-download"></i></button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div style="align-self:center;margin-top:25px;">
                        {!! $files->links() !!}
                    </div>
                </div>
            </div>
        @endsection
