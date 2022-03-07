@extends('admaster')
@section('content')

<main>
    <div class="container-fluid px-4">
         {{-- error message check --}}
        @if(session('error_msg'))
        <p class="error_msg">{{session('error_msg')}}</p>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="/#!">Dashboard</a></li>
                    <li class="breadcrumb-item active">Files</li>
                </ol>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Files
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Total Uploaded</th>
                            <th>Total Process</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>File Name</th>
                            <th>Total Uploaded</th>
                            <th>Total Process</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{$file->name}}</td>
                                    <td>{{$file->total_uploads}}</td>
                                    <td>{{$file->total_process}}</td>
                                   
                                    <td><button type="button" class="btn btn-primary flie-btn" id={{$file->id}} data-bs-toggle="modal" data-bs-target="#chunkfileModal">
                                        File Group
                                      </button></td>
                                </tr>
                                {{-- /user/file/{{$file->id}}/chunk_file --}}
                            @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

 <!-- Group information Modal -->
 <div class="modal fade" id="chunkfileModal" tabindex="-1" aria-labelledby="chunkfileModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Group Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Total Contact</th>
                                <th>Action</th>
                            </tr>
                        </thead>
            
                        <tbody class="chunk_tbody"> 
            
                        </tbody>
                    </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
    </div>
  </div>
<!-- Group information Modal -->

<script>
    $(document).ready(function(){
        $(".flie-btn").click(function(e){
            e.preventDefault();
            // let id_key = 'id'
            let id = this.id;
            $.ajax({
                type: "GET",
                url: `/user/file/chunk_file`,
                data: {
                  id: id
                },
                dataType: "json",
                success: function(response) {
                    $.each(response.chunk_file, function(key, item) {
                        $('.chunk_tbody').append(
                            '<tr>\
                                <td>'+item.name+'</td>\
                                <td>'+item.total_contact+'</td>\
                                <td><a href="/user/contact/'+item.id+'/show" type="button" class="btn btn-info">Group</a></td>\
                            </tr>'
                        );
                    });
                }
            })
        })
    })
</script>
@endsection