

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
                  <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-lg">Add Internal Requisition</button>
                <h3 class="card-title">Commitment from Budget </h3>
              </div>

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
                <table id="requisition-table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Select</th>
                    <th>Requisition No.</th>
                    <th>Requested by</th>
                    <th>Estimated Cost</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>phone</th>
                    {{-- <th>EmailAddress</th> --}}
                    <th>Type</th>
                    {{-- <th>Request Required</th> --}}
                    <th>Priority</th>
                  </tr> 
                  </thead>
                  <tbody>
               
                 @foreach($internalrequisitions as $internal_requisition)
                 <tr>
                 <td> <a href="/budgetcommitment/create/{{$internal_requisition->id}}" class="btn btn-block btn-success btn-sm">Select</a> </td>
                 <td>{{$internal_requisition->requisition_no}}</td>
                 <td>{{$internal_requisition->user->firstname[0]}}.{{$internal_requisition->user->lastname}}</td>
                 <td>{{$internal_requisition->estimated_cost}}</td>
                 <td>{{$internal_requisition->department->name}}</td>
                 <td>{{$internal_requisition->institution->name}}</td>
                 <td>{{$internal_requisition->budget_approve}}</td>
                 <td>{{$internal_requisition->phone}}</td>
                 {{-- <td>{{$internal_requisition->email}}</td> --}}
                 <td>{{$internal_requisition->requisition_type->name}}</td>
                 <td>{{$internal_requisition->priority}}</td>
                 {{-- <td>{{$internal_requisition->created_at}}</td> --}}
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
                    <th>Requisition No.</th>
                    {{-- <th>Requisition_no</th> --}}
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
                    <th>Option</th>
                    <th></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($budgetCommitment as $commitment)
                    <tr>
                       {{-- <td>{{$order->id}}</td>
                      @if($order->approvePurchaseOrder)
                    <td> <span class ="badge bg-green">Approved</span></td>
                    @else
                    <td> <span class ="badge bg-red">Not approved</span></td>
                    @endif --}}
                   
                    <td>{{$commitment->internalrequisition->requisition_no}}</td>
                    <td>{{$commitment->internalrequisition->estimated_cost}}</td>
                    <td>{{$commitment->internalrequisition->budget_approve}}</td>
                    <td>{{$commitment->internalrequisition->department->name}}</td>
                    <td>{{$commitment->internalrequisition->institution->name}}</td>
                    <td>{{$commitment->internalrequisition->requisition_type->name}}</td>
                    <td>{{$commitment->internalrequisition->priority}}</td>
                    <td>{{$commitment->commitment_no}}</td>
                    <td>{{$commitment->account_code}}</td>
                    <td>{{$commitment->comment}}</td>
                    <td>{{$commitment->created_at}}</td>
                    

                    
                   
                    <td>
                     <a  href="/budgetcommitment/{{$commitment->id}}/edit" class="btn btn-block btn-primary btn-m" >Edit</a> 
                    </td>
                    <td>
                    <a href="" class="btn btn-block btn-danger btn-m">Delete</a>
                    </td> 

                      
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
         "scrollX": true
    });
    
} );


$(document).ready( function () {
    $('#requisition-table').DataTable({
         "scrollX": true
    });
    
} );
</script>

@endpush