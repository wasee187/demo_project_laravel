@extends('admaster')
@section('content')
<main>
    <div class="container-fluid px-4">
        {{-- error/success message check --}}
        @if(session('error_msg'))
        <p class="error_msg">{{session('error_msg')}}</p>
        @endif
        @if(session('log_success'))
        <p class="suc_msg">{{session('log_success')}}</p>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="/#!">Dashboard</a></li>
                    <li class="breadcrumb-item active">file upload</li>
                </ol>
            </div>
        </div>
        <div class="card mb-4">
            
          <form action="/user/contact" method="POST" enctype="multipart/form-data" class="file-form">
            <div class="form-group">
                @csrf
                <label for="filename">File Name</label>
                <input type="text" name='filename' class="form-control" id="filename" placeholder="File Name">
                <span class="err-msg">@error('filename'){{$message}}@enderror</span>
            </div>
            <div class="form-group">
                <label for="chunkPoint">Chunk Point</label>
                <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" id="chunkPoint" name='chunkPoint'>
                    <option selected>100</option>
                    <option>200</option>
                    <option>300</option>
                    <option>500</option>
                </select>
                <span class="err-msg">@error('chunkPoint'){{$message}}@enderror</span>
            <div>
            <div class="form-group">
                <input class="form-control" type="file" id="formFile" name="file" accept=".csv">
                <span class="err-msg">@error('file'){{$message}}@enderror</span>
            </div>
            <div>
                <button type="submit" class="btn btn-primary up-btn">Upload File</button>
            </div>
          </form>
        </div>
    </div>
</main>
@endsection