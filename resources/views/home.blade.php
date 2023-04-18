@extends('layouts.master')

@section('content')
    <?php
    $userId = auth()->user()->id;
    $results = DB::select("select * from files where userId = $userId");
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
                foreach ($results as $result) {
                    $spaceTaken = $spaceTaken + number_format($result->file_size / 1024 / 1024, 2);
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
                    <div class="grid">
                        <div></div>
                        <div>Name</div>
                        <div>Added</div>
                        <div>Size</div>
                        <div></div>
                    </div>
                    <div class="grid">
                        @foreach ($results as $file)
                            <?php
                            $name = decrypt($file->name);
                            $fileExtension = substr($name, strpos($name, '.') + 1);
                            ?>

                            <?php switch($fileExtension): case ($fileExtension === "png" || $fileExtension ==="jpeg" || $fileExtension ==="jpg"): ?>
                            <div><i class="fa fa-picture-o"></i></div>
                            <?php break; ?>

                            <?php case "pdf": ?>
                            <div><i class="fa fa-file-pdf-o" aria-hidden="true"></i></div>
                            <?php break; ?>

                            <?php case "xdoc": ?>
                            <div>xdoc image</div>
                            <?php break; ?>

                            <?php case "xlsx": ?>
                            <div>xlsx image</div>
                            <?php break; ?>
                            <?php case "mp3": ?>
                            <div>mp3 image</div>
                            <?php break; ?>
                            <?php case "pptx": ?>
                            <div>pptx image</div>
                            <?php break; ?>
                            <?php endswitch; ?>

                            <div><?php echo $name; ?></div>
                            <div><?php echo $file->created_at; ?></div>
                            <div><?php
                            $size_mb = number_format($file->file_size / 1024 / 1024, 2);
                            
                            echo $size_mb . 'MB'; ?></div>
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
                </div>
            </div>
        @endsection
