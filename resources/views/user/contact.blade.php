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
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Contact Table
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Firstname</th>
                            <th>lastName</th>
                            <th>Email</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Number</th>
                            <th>Firstname</th>
                            <th>lastName</th>
                            <th>Email</th>
                            <th>State</th>
                            <th>Zip</th>
                            <th>Created At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{$contact->number}}</td>
                                    <td>{{$contact->firstname}}</td>
                                    <td>{{$contact->lastname}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->state}}</td>
                                    <td>{{$contact->zip}}</td>
                                    <td>{{$contact->created_at}}</td>
                                </tr>
                            @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection