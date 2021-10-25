

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Unit Measurements</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
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
                  
                  <a href="measurement/create" class="btn btn-success float-left">Create measurement</a>
                <h3 class="card-title float-right">A list of all unit of measurements</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Abbr</th>
                    <th>Description</th>
                    <th>Created At</th>
                   
                    
                  </tr>
                  </thead>
                  <tbody>
                @foreach($measurements as $measurement)
                    <tr>
                      <td>
                        <a  href="/measurement/{{$measurement->id}}/edit" class="btn btn-block btn-primary btn-m" >Edit</a> 
                        </td>
                        <td>
                        <a href="#" onclick="deleteMeasurement({{$measurement->id}})" class="btn btn-block btn-danger btn-m">Delete</a>
                        </td> 
                    <td>{{$measurement->id}}</td>
                    <td> {{$measurement->name}}</td>
                    <td>{{$measurement->abbr}}
                    <td>{{$measurement->description}}</td>
                    <td>{{$measurement->created_at}}</td>
                    
                    </tr>
                    @endforeach 
            
                 
                 
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> --}}
                </table>
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
<script src="/plugins/datatables/dataTables.select.min.js"></script>
<script src="/js/dataTables.select.min.js"></script>
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
      //   "scrollX": true
    });
    
} );

function deleteMeasurement(Id){
    swal({
        title: "Are you sure?",
        text: "You will not be able to undo this action once it is completed!",
        dangerMode: true,
        cancel: true,
        buttons: ["Cancel", "Yes, Delete it!"],
        closeOnConfirm: false
    }).then(isConfirm => {
            if (isConfirm) {
                $.get( {!! json_encode(url('/')) !!} + "/measurement/delete/" + Id).then(function (data) {
                   console.log(Id);
                    if (data == "success") {
                        swal(
                            "Done!",
                            "Unit of measurement delete was successful!.",
                            "success").then(esc => {
                                if(esc){
                                    location.reload();
                                }
                            });
                    }else{
                        swal(
                            "Oops! Something went wrong.",
                            "Unit of measurement delete was NOT successful.",
                            "error");
                    }
                });
            }
        });
}

</script>

@endpush