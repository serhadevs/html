

@extends('layouts.panel-master')

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> 

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase Order</h1>
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
                  <button class="btn btn-outline-success float-left btn-lg" data-toggle="modal" data-target="#modal-lg">Add Purchase Order</button>
                <h3 class="card-title  float-right">A list of all procurement order </h3>
              </div>

            {{-- modal started --}}

<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Purchase Order List</h4>
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
                    <th>Option</th> 
                    <th>Requisition_no</th>
                    {{-- <th>Date Receive</th>  --}}
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                     <th>Cost Centre</th>
                    <th>Commitment #</th>
                  </tr> 
                  </thead>
                  <tbody>
               
                 @foreach($requisitions as $requisition)
                 <tr>
                 <td> <a href="/purchase-order/create/{{$requisition->id}}" class="btn btn-outline-success btn-m">Select</a> </td>
                <td>{{$requisition->requisition_no}}</td>
                {{-- <td>{{$requisition->approve->created_at}}</td> --}}
                <td>{{$requisition->department->name}}</td>
                <td>{{$requisition->institution->name}}</td>
                <td>{{$requisition->institution->parish->name}}</td>
                <td>{{$requisition->supplier->name}}</td>
                <td>{{$requisition->cost_centre}}</td>
                <td>{{$requisition->commitment_no}}</td>
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
                    {{-- <th>Approve</td> --}}
                    <th>Option</th>
                    <th></th>
                    <th>Requisition_no</th>
                    <th>Purchase Order No.</th>
                    <th>Cost Centre</th>
                    <th>Prepared_by</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    {{-- <th>Order Total</th>
                    <th>Approve By</th>
                    <th>Approve Date</th> --}}
                   
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($purchase_orders as $order)
                    <tr>
                       {{-- <td>{{$order->id}}</td> --}}
                      {{-- @if($order->approvePurchaseOrder)
                    <td> <span class ="badge bg-green">Approved</span></td>
                    @else
                    <td> <span class ="badge bg-red">Not approved</span></td>
                    @endif --}}
                    <td>
                      <a  href="/purchase-order/{{$order->id}}/edit" class="btn btn-outline-primary btn-m" >Edit</a> 
                     </td>
                     <td>
                     <a href="#" onclick= "deletePurchaseOrder({{$order->id}})" class="btn btn-outline-danger btn-m">Delete</a>
                     </td>  
                   
                    <td>{{$order->requisition->requisition_no}}</td>
                    <td>{{$order->purchase_order_no}}</td>
                    <td>{{$order->requisition->cost_centre}}</td>
                    <td>{{$order->user->firstname[0]}}.{{$order->user->lastname}}</td>
                    <td>{{$order->requisition->department->name}}</td>
                    <td>{{$order->requisition->institution->name}}</td>
                    <td>{{$order->requisition->institution->parish->name}}</td>
                    <td>{{$order->requisition->Supplier->name}}</td>
                    {{-- <td>{{$order->order_total}}</td>
                    @if($order->approvePurchaseOrder)
                    <td>{{$order->approvePurchaseOrder->user->firstname[0]}}.{{$order->requisition->approve->user->lastname}} </td>
                    <td>{{$order->approvePurchaseOrder->created_at}}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif --}}
                   
                      
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
      </br>
    </br>

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


$(document).ready( function () {
    $('#requisition-table').DataTable({
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
      //   paging:         true,
    });
    
} );



function deletePurchaseOrder(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/purchase-order/delete/" + Id).then(function (data) {
        console.log(data);
        if (data == "success") {
          swal(
            "Done!",
            "Purchase Order was successfully deleted!",
            "success").then(esc => {
              if(esc){
                location.reload();
              }
            });
          }
          else if(data=="existing"){
            swal("Error",
            "This permit is already signed off and is not allowed to be deleted.",
            "error");
          }
          else{
            swal(
              "Oops! Something went wrong.",
              "Purchase Order was NOT deleted.",
              "error");
            }
          });
        }
      });
    }
</script>

@endpush