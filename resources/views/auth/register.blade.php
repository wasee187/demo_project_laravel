@extends('master')
@section('content')
<div class="logForm-container">
    <div class="log-form">
        {{-- login form --}}
        @if(session('log_error'))
        <p class="err-msg">{{session('log_error')}}</p>
        @endif
        <h3>Register</h3>
        <form action='/register' id='loginForm' method='POST'> 
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
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
        <a href="/login">Login</a>
    </div>
</div>