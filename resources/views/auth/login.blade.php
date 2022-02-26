@extends('master')
@section('content')
<div class="logForm-container">
    <div class="log-form">
        {{-- login form --}}
        <h3>Login</h3>
        @if(session('log_error'))
        <p class="err-msg">{{session('log_error')}}</p>
        @endif
        <form action='login' id='loginForm' method='POST'> 
            <div class="form-group">
                @csrf
                <input type="text" name='email' class="form-control" id="email" value="{{old("email")}}" placeholder="Email">
                <span class="err-msg">@error('email'){{$message}}@enderror</span>
            </div>
            <div class="form-group">
                <input type="password" name='password' class="form-control" id="password" placeholder="Password">
                <span class="err-msg">@error('password'){{$message}}@enderror</span>
            </div>

            <div>
            <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <a href="/register">Register New Account</a>
    </div>
</div>