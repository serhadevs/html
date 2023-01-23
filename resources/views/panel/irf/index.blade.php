

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')

<div class="card-body">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Internal Requisition </h1>
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
                  
                  <a href="internal_requisition/create" class="btn btn-outline-success float-left">Create IPR</a>
                <h3 class="btn btn float-right" class="card-title">A list of all Internal Requisition Form</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Option</th>
                    <th></th>
                    <th></th>
                    <th>Status</th>
                    <th>Requisition No.</th>
                    <th>Requested by</th>
                    <th>Description</th>
                    <th>Estimated Cost</th>
                    <th>Unit</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>phone</th>
                    <th>Email</th>
                    <th>Request Required</th>
                    <th>Priority</th>
                    <th>Date Created</th>
                    {{-- <th>Date Approved</th> --}}
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($internal_requisitions as $internal_requisition)
                    <tr>
                    {{-- <td>{{$internal_requisition->id}}</td> --}}

                    <td>
                      <a  href="/internal_requisition/{{$internal_requisition->id}}/edit" class="btn btn-outline-primary btn-m" >Edit</a> 
                     </td>
                     <td>
                       <a  href="/internal_requisition/{{$internal_requisition->id}}" class="btn btn-outline-success btn-m" >View</a> 
                      </td>
                     <td>
                     <a href="#" class="btn btn-outline-danger btn-m" onclick="deleteinternal_requisition({{$internal_requisition->id}})" >Delete</a>
                     </td> 
                     @if(isset($internal_requisition->status))
                    <td> <span class ="badge bg-green">{{$internal_requisition->status->name}}</span></td>
                    @else
                    <td> <span class ="badge bg-warning">Error warning</span></td>
                    @endif
                    <td>{{$internal_requisition->requisition_no}}
                    <td>{{$internal_requisition->user->abbrName()}}</td>
                    <td>{{$internal_requisition->description}}</td>
                    <td>${{number_format($internal_requisition->estimated_cost,2)}}</td>
                    <td>{{$internal_requisition->user->unit->name}}</td>
                    <td>{{$internal_requisition->department->name}}</td>
                    <td>{{$internal_requisition->institution->name}}</td>
                    <td>{{$internal_requisition->budget_approve}}</td>
                    <td>{{$internal_requisition->phone}}</td>
                    <td>{{$internal_requisition->email}}</td>
                    <td>{{$internal_requisition->requisition_type->name}}</td>
                    <td>{{$internal_requisition->priority}}</td>
                    <td>{{$internal_requisition->created_at}}</td>
               
                  
                   
                   
                    
                  
                   
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
 <script src="https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js"></script>
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
      aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
      scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
    });
    
} );


function deleteinternal_requisition(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/internal_requisition/delete/" + Id).then(function (data) {
        console.log(data);
        if (data == "success") {
          swal(
            "Done!",
            "Internal Requisition was successfully deleted!",
            "success").then(esc => {
              if(esc){
                location.reload();
              }
            });
          }
          else if(data=="fail"){
            swal("Error",
            "This Internal requisition is already approved and is not allowed to be deleted.",
            "error");
          }
          else{
            swal(
              "Oops! Something went wrong.",
              "Internal Requisition was NOT deleted.",
              "error");
            }
          });
        }
      });
    }
</script>

@endpush