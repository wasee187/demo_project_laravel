@extends('master')
@section('content')
<div class="logForm-container">
    <div class="log-form">
        {{-- login form --}}
        @if(session('log_error'))
        <p class="err-msg">{{session('log_error')}}</p>
        @endif
        <h3>Edit User</h3>
        <form action="/users/{{$user->id}}" id='loginForm' method='POST'> 
            @method('PUT')
            <div class="form-group">
                @csrf
                <input type="name" name='name' class="form-control" id="name" value="{{$user->name}}" placeholder="Name">
                <span class="err-msg">@error('name'){{$message}}@enderror</span>
                </div>
            <div class="form-group">
                <input type="email" name='email' class="form-control" id="email" value="{{$user->email}}" placeholder="Email">
                <span class="err-msg">@error('email'){{$message}}@enderror</span>
            </div>
       
            <div class="form-group">
                <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" id="role" name='role'>
                    @if ($user->role=='Admin')
                        <option selected>Admin</option>
                            <option>User</option>
                        @else
                            <option>Admin</option>
                            <option selected>User</option>
                        @endif
                </select>
                <span class="err-msg">@error('role'){{$message}}@enderror</span>
            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        <a href="/login">Login</a>
    </div>
</div>