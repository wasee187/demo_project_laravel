@extends('admaster')
@section('content')
<main>
    <div class="container-fluid px-4">
        @if(session('log_success'))
        <p class="suc_msg">{{session('log_success')}}</p>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    <li class="breadcrumb-item active">User List</li>
                </ol>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                User Data Table
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Staus</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    @if(Session::get('user') && Session::get('user')['id']== $user->id)
                                       {{-- disabling status button if logged in user --}}

                                        <td><button class="btn btn-success" disabled>{{$user->status}}</button></a>
                                    @else
                                        <td>
                                            <form action="admin/user/{{$user->id}}/status" method='POST'>
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                    @if($user->status =='Blocked')
                                                     class="btn btn-danger"
                                                    @else
                                                        class="btn btn-success"
                                                    @endif
                                                    
                                                    >{{$user->status}}</button>
                                            </form>
                                        </td>
                                    @endif

                                    <td><a type="button" class="btn btn-primary" href={{"admin/user/$user->id/edit"}}>Edit</td></a>
                                    
                                    @if(Session::get('user') && Session::get('user')['id']== $user->id) 
                                    {{-- disabling delete button if logged in user --}}
                                        <td><button class="btn btn-warning" disabled>Delete</button></a>
                                    @else
                                        <td>   
                                            <form action="/admin/user/{{$user->id}}/delete" method='POST'>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                    
                                    {{-- <td><a type="button" class="btn btn-warning" href={{"delete/".$user["id"]}}>Delete</td></a> --}}
                                </tr>
                            @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection