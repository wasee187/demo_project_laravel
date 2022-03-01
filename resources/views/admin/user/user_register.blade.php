@extends('admaster')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
            <li class="breadcrumb-item active">User</li>
            <li class="breadcrumb-item active">Register</li>
        </ol>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
            User Registration
    </div>
    <div class="card-body regform">
        <form action='/admin/user/register' id='userRegForm' method='POST'> 
            <div class="form-group">
                @csrf
                <input type="name" name='name' class="form-control" id="name" value="{{old("name")}}" placeholder="Name">
                <span class="err-msg">@error('name'){{$message}}@enderror</span>
            </div>
            <div class="form-group">
                <input type="email" name='email' class="form-control" id="email" value="{{old("email")}}" placeholder="Email">
                <span class="err-msg">@error('email'){{$message}}@enderror</span>
            </div>
            <div class="form-group">
                <input type="password" name='password' class="form-control" id="password" placeholder="Password">
                <span class="err-msg">@error('password'){{$message}}@enderror</span>
            </div>
    
            <div>
                <button type="submit" class="userRegBTN btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</div>

@endsection