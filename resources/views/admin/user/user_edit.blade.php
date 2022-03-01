@extends('admaster')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
            <li class="breadcrumb-item active">User</li>
            <li class="breadcrumb-item active">Edit</li>
            <li class="breadcrumb-item active">{{$user->name}}</li>
        </ol>
    </div>
</div>
<div class="card mb-4 user-update">
    {{-- <div class="card-header">
        <i class="fas fa-table me-1"></i>
            Edit User
    </div> --}}
    <div class="card-body user-update-card">
        <h3>Edit User</h3>
        <form action="/admin/user/{{$user->id}}/update" id='userEditForm' method='POST'> 
            @method('PUT')
            <div class="form-group">
                @csrf
                <label for="name">Name</label>
                <input type="name" name='name' class="form-control" id="name" value="{{$user->name}}" placeholder="Name">
                <span class="err-msg">@error('name'){{$message}}@enderror</span>
                </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name='email' class="form-control" id="email" value="{{$user->email}}" placeholder="Email">
                <span class="err-msg">@error('email'){{$message}}@enderror</span>
            </div>
            
            <div class="form-group">
                <label for="status">User Status</label>
                <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" id="status" name='status'>
                    @if ($user->role=='Blocked' || $user->role=='blocked')
                        <option selected>Blocked</option>
                            <option>Unblocked</option>
                        @else
                            <option>Blocked</option>
                            <option selected>Unblocked</option>
                        @endif
                </select>
                <span class="err-msg">@error('status'){{$message}}@enderror</span>
            <div>
            <div class="form-group">
                <label for="Role">User Role</label>
                <select class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" id="role" name='role'>
                    @if ($user->role=='Admin' || $user->role=='admin')
                        <option selected>Admin</option>
                            <option>User</option>
                        @else
                            <option>Admin</option>
                            <option selected>User</option>
                        @endif
                </select>
                <span class="err-msg">@error('role'){{$message}}@enderror</span>
            <div>
                <button type="submit" class="btn btn-primary user-update-btn">Update User</button>
            </div>
        </form>
    </div>

</div>

@endsection