




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Department List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
              <li class="breadcrumb-item "><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
      <div class="container-fluid">
      
        <div class="row">
              
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  
                  <a href="department/create" class="btn btn-outline-success float-left btn-lg">Add Department</a>
                <h3 class="card-title float-right">Departments </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
                  @csrf --}}
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                <th></th>
                <th></th>
                <th class="text-center">ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">abbr</th>
                <th class="text-center">created</th>
               
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($departments as $department)
                  <tr>
                    <td>  
                      <a  href="/department/{{$department->id}}/edit" class="btn  btn-outline-primary btn-m" >Edit</a> 
                      </td>
                      <td>
                      <button class="btn btn-outline-danger btn-m" onclick="deleteDepartment({{$department->id}})">Delete</button>
                      </td> 
                    <td>{{$department->id}}</td> 
                   <td>{{$department->name}}</td>  
                    <td>{{$department->abbr}}</td>  
                     <td>{{$department->created_at}}</td>  
                     
                       
                    

                             
                          


                  </tr>  

                  @endforeach
                    
                 
                 
                  </tbody>
                  
                </table>
              </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </div>
@endsection


@include('partials.datatable-scripts')

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@push('scripts')
{{-- <script src="/plugins/datatables/dataTables.select.min.js"></script> --}}
{{-- <script src="/js/dataTables.select.min.js"></script> --}}

<script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script src="/js/sweet/sweetalert.min.js"></script> 
 
@endpush
  
@if(session('status'))
  @push('scripts')
    <script>
    $(document).ready(function(){
      swal("{!! session('status') !!}", "", "success");
    });
    </script>
  @endpush
@endif

@if(session('error'))
  @push('scripts')
    <script>
    $(document).ready(function(){
      swal("{!! session('error') !!}", "", "error");
    });
    </script>
  @endpush
@endif


@push('scripts')
<script>
$(document).ready( function () {
    $('#table').DataTable({
        //  "scrollX": true,
    });
    
} );



function deleteDepartment(Id){
    swal({
        title: "Are you sure?",
        text: "You will not be able to undo this action once it is completed!",
        dangerMode: true,
        cancel: true,
        buttons: ["Cancel", "Yes, Delete it!"],
        closeOnConfirm: false
    }).then(isConfirm => {
            if (isConfirm) {
                $.get( {!! json_encode(url('/')) !!} + "/department/delete/" + Id).then(function (data) {
                   console.log(Id);
                    if (data == "success") {
                        swal(
                            "Done!",
                            "Department delete was successful!.",
                            "success").then(esc => {
                                if(esc){
                                    location.reload();
                                }
                            });
                    }else{
                        swal(
                            "Oops! Something went wrong.",
                            "Department delete was NOT successful.",
                            "error");
                    }
                });
            }
        });
    }

  // $.get( {!! json_encode(url('/')) !!} + "/foodhandlers/delete/" + permitId).then(function (data) 
 // $.post( {!! json_encode(url('/sign-off/approve')) !!}, { _method: "POST", data: {selected_items: selected_items, appTypeId: appTypeId}, _token: "{{ csrf_token() }}" }).then(function (data)

</script>

@endpush

