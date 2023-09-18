

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
            <h1>Requisitions</h1>
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
                  
                  {{-- <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a> --}}
                  <button class="btn btn-outline-success float-left" data-toggle="modal" data-target="#modal-lg">Create Requisition</button>
                  <h3 class="card-title float-right">A list of all procurement requisition </h3>
              </div>
              <!-- /.card-header -->

                       {{-- modal started --}}

<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Internal Requisition List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="card-body">
          {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
            @csrf --}}
          <table id="internal-requisition-table" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Select</th>
              <th>Requisition No.</th>
              <th>Requested by</th>
              <th>Estimated Cost</th>
              <th>Description</th>
              <th>Department</th>
              <th>Institution</th>
              <th>Budget Activity </th>
              <th>phone</th>
              {{-- <th>EmailAddress</th> --}}
              <th>Type</th>
              <th>Priority</th>
              <th>Assign To</th>
            </tr> 
            </thead>
            <tbody>
         
           @foreach($internalrequisitions as $internal_requisition)
           <tr>
           <td> <a href="/requisition/create/{{$internal_requisition->id}}" class="btn btn-outline-success btn-lg">Select</a> </td>
           <td>{{$internal_requisition->requisition_no}}</td>
           <td>{{$internal_requisition->user->firstname[0]}}.{{$internal_requisition->user->lastname}}</td>
           <td>${{number_format($internal_requisition->estimated_cost,2)}}</td>
            <td>{{$internal_requisition->description}}</td>
           <td>{{$internal_requisition->department->name}}</td>
           <td>{{$internal_requisition->institution->name}}</td>
           <td>{{$internal_requisition->budget_approve}}</td>
           <td>{{$internal_requisition->phone}}</td>
           <td>{{$internal_requisition->requisition_type->name}}</td>
           <td>{{$internal_requisition->priority}}</td>
           @if($internal_requisition->assignto)
            <td>{{$internal_requisition->assignto->user->lastname}}</td>
           @else
            <td></td>
           @endif
           </tr>
           @endforeach 
           
           
            </tbody>
            
          </table>
        </form>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


        {{-- modal ended --}}
        <!-- /.card-header -->















              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    {{-- <th>ID</th> --}}
                    <th>Option</th>
                    <th></th>
                    <th></th>
                    <th>Requisition_no</th>
                    <th>Date Received in Procurement</th>
                    <th>Date returned to Institution</th>
                    <th>Date Re-submitted to Procurement</th>
                    <th>Requestor/Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    <th>Category</th>
                    <th>(Item/Description)</th>
                    <th>Contract Value</th>
                    <th>Date Sent to Procurement Officer</th>
                    <th>Date Sent for approval</th>
                    <th>Date Sent to Purchasing Officer</th>
                    <th>Date P.O Printed</th>
                    <th>P.O # / Contract #</th>
                    <th>Date submmited to Accounts for Pre-Payment</th>
                    <th>Date P.O Sent to Institution</th>
                    <th>Date document returned to institution</th>
                    <th>Date Final Invoice Received</th>
                    <th>Invoice Number</th>
                    <th>Date submmited to Accounts for Payment</th> 
                    <th>Created By</th>
                   
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($requisitions as $requisition)
                    <tr>
                    {{-- <td>{{$requisition->id}}</td> --}}
                    <td>
                      <a  href="/requisition/{{$requisition->id}}/edit" class="btn btn-outline-primary btn-m" >Edit</a> 
                     </td>
                     <td>
                       <a  href="/requisition/{{$requisition->id}}" class="btn  btn-outline-success btn-m" >view</a> 
                      </td>
                     <td>
                     <a href="#" class="btn  btn-outline-danger btn-m" onclick="deleteRequisition({{$requisition->id}})" >Delete</a>
                     </td> 
                    <td>{{$requisition->requisition_no}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
                    <td></td>
                    <td></td>
                     @if(isset($requisition->internalrequisition))
                    <td>{{$requisition->internalrequisition->user->abbrName()."   "." / ". $requisition->department->name}}</td>
                    @else
                    <td>{{$requisition->department->name}}</td>
                    @endif
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->institution->parish->name}}</td>
                    @if(isset($requisition->supplier))
                    <td>{{$requisition->supplier->name}}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{$requisition->category->name}}</td>
                    <td>{{$requisition->description}}</td>
                    <td>${{number_format($requisition->contract_sum,2)}} {{$requisition->internalrequisition->currency->abbr}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
                    @if($requisition->check)
                    <td>{{Carbon\Carbon::parse($requisition->check->created_at)->format('Y-M-d')}}</td>
                    @else
                      <td></td>
                    @endif
                    @if($requisition->approve)
                    <td>{{Carbon\Carbon::parse($requisition->approve->created_at)->format('Y-M-d')}}</td>
                    @else
                     <td></td>
                     @endif
                    
                    @if($requisition->purchase_order)
                      <td>{{Carbon\Carbon::parse($requisition->purchase_order->created_at)->format('Y-M-d')}}</td>
                    <td>{{$requisition->purchase_order->purchase_order_no}}</td>
                    @else
                    <td></td>
                    <td></td>
                    
                    @endif
                    <td>Date submmited to Accounts for Pre-Payment</td>
                    <td>Date P.O Sent to Institution</td>
                    <td>Date document returned to institution</td>
                    <td>Date Final Invoice Received</td>
                    <td>Invoice Number</td>
                    <td>Date submmited to Accounts for Payment</td> 
                    
            
                    <td>{{$requisition->user->abbrName()}}</td>

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
         scrollY:        "600px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
    });
    
} );

$(document).ready( function () {
    $('#internal-requisition-table').DataTable({
         scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
    });
    
} );


function deleteRequisition(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/requisition/delete/" + Id).then(function (data) {
        console.log(data);
        if (data == "success") {
          swal(
            "Done!",
            "Requisition was successfully deleted!",
            "success").then(esc => {
              if(esc){
                location.reload();
              }
            });
          }
          else if(data=="fail"){
            swal("Error",
            "This Requisition is already accepted and is not allowed to be deleted.",
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