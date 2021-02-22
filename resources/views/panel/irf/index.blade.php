

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Internal Requisition Form</h1>
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
                  
                  <a href="internal_requisition/create" class="btn btn-success float-right">Create IR</a>
                <h3 class="card-title">A list of all Internal Requisition Form</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Requisition No.</th>
                    <th>Requested by</th>
                    <th>Estimated Cost</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>phone</th>
                    <th>Email</th>
                    <th>Request Required</th>
                    <th>Priority</th>
                    <th>Date Created</th>
                    <th>Date Approved</th>

                    <th>Option</th>
                    <th></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($internal_requisitions as $internal_requisition)
                    <tr>
                    <td>{{$internal_requisition->id}}</td>
                    <td>{{$internal_requisition->requisition_no}}
                    <td>{{$internal_requisition->user->firstname[0]}}.{{$internal_requisition->user->lastname}}</td>
                    <td>{{$internal_requisition->estimated_cost}}</td>
                    
                    <td>{{$internal_requisition->department->name}}</td>
                    <td>{{$internal_requisition->institution->name}}</td>
                    <td>{{$internal_requisition->budget_approve}}</td>
                    <td>{{$internal_requisition->phone}}</td>
                    <td>{{$internal_requisition->email}}</td>
                    <td>{{$internal_requisition->requisition_type->name}}</td>
                    <td>{{$internal_requisition->priority}}</td>
                    <td>{{$internal_requisition->created_at}}</td>
                    @if($internal_requisition->approve_internal_requisition)
                    <td>{{$internal_requisition->approve_internal_requisition->created_at}}</td>
                    @else
                    <td></td>
                    @endif
                   
                    
                  
                   
                    <td>
                     <a  href="/internal_requisition/{{$internal_requisition->id}}/edit" class="btn btn-block btn-primary btn-m" >Edit</a> 
                    </td>
                    <td>
                    <a href="#" class="btn btn-block btn-danger btn-m" onclick="deleteinternal_requisition({{$internal_requisition->id}})" >Delete</a>
                    </td> 
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
         "scrollX": true
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
            "Permit Application was successfully deleted!",
            "success").then(esc => {
              if(esc){
                location.reload();
              }
            });
          }
          else if(data=="existing_sign_off"){
            swal("Error",
            "This permit is already signed off and is not allowed to be deleted.",
            "error");
          }
          else{
            swal(
              "Oops! Something went wrong.",
              "Permit Application was NOT deleted.",
              "error");
            }
          });
        }
      });
    }
</script>

@endpush