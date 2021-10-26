

@extends('layouts.panel-master')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> 

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Commit Budget</h1>
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
    <section class="content">
        
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  {{-- /purchase-order/create --}}
                  {{-- <button class="btn btn-success float-left" data-toggle="modal" data-target="#modal-lg">Add Internal Requisition</button> --}}
                <h3 class="card-title float-left">Commitment from Budget </h3>
              </div>

          


              
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Requisition No.</th>
                    <th>Requester</th>
                    <th>Estimated Cost</th>
                    <th>Budget Activity</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Procurement</th>
                    <th>Priority</th>
                    <th>Commitment No:</th>
                    <th>Accounting Code:</th>
                    <th>Comments</th>
                    <th>Created date</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($internalrequisitions as $internalrequisition)
                    <tr>
                       {{-- <td>{{$order->id}}</td>
                      @if($order->approvePurchaseOrder)
                    <td> <span class ="badge bg-green">Approved</span></td>
                    @else
                    <td> <span class ="badge bg-red">Not approved</span></td>
                    @endif --}}
                  
                      {{-- <a  href="/budgetcommitment/{{$commitment->id}}/edit" class="btn btn-block btn-primary btn-m" >Edit</a>  --}}
                     
                      @if($internalrequisition->budget_commitment)
                         <td> <button href="#" class="btn btn-block btn-success btn-m" disabled>Committed</button> </td> 
                      <td><a href="/budgetcommitment/{{$internalrequisition->budget_commitment->id}}/edit" class="btn btn-block btn-outline-primary  btn-m" >Edit</a></td>
                      <td><button href="#" class="btn btn-block btn-outline-danger  btn-m"  onclick="deleteCommitment({{$internalrequisition->budget_commitment->id}})">Delete</button></td>
                        @else
                        <td> <a href="/budgetcommitment/create/{{$internalrequisition->id}}" class="btn btn-block btn-outline-success  btn-m ">Commit</button> </td> 
                        <td><button  href="#" class="btn btn-block btn-primary btn-m"  disabled>Edit</button></td>
                        <td><button href="#" class="btn btn-block btn-danger btn-m"   disabled>Delete</button></td>
                    
                     @endif
                    <td>{{$internalrequisition->requisition_no}}</td>
                    <td>{{$internalrequisition->user->abbrName()}}</td>
                    <td>{{$internalrequisition->estimated_cost}}</td>
                    <td>{{$internalrequisition->budget_approve}}</td>
                    <td>{{$internalrequisition->department->name}}</td>
                    <td>{{$internalrequisition->institution->name}}</td>
                    <td>{{$internalrequisition->requisition_type->name}}</td>
                    <td>{{$internalrequisition->priority}}</td>                       
                    @if($internalrequisition->budget_commitment)
                    <td>{{$internalrequisition->budget_commitment->commitment_no}}</td>
                    <td>{{$internalrequisition->budget_commitment->account_code}}</td>
                    <td>{{$internalrequisition->budget_commitment->comment}}</td>
                    <td>{{$internalrequisition->budget_commitment->created_at}}</td> 
                    @else
                     <td>{{null}}</td>
                     <td>{{null}}</td>
                     <td>{{null}}</td>
                     <td>{{null}}</td>
                    @endif
                    </tr>  
               
                  @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          </div>
@endsection


@include('partials.datatable-scripts')

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
<script src="/plugins/datatables/dataTables.select.min.js"></script>
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
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
    });
    
} );



function deleteCommitment(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/budgetcommitment/destroy/" + Id).then(function (data) {
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
          else if(data=="fail"){
            swal("Error",
            "This application is already approved and is not allowed to be deleted.",
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