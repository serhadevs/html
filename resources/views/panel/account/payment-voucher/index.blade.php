

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment Voucher</h1>
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
                  <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal-lg">Create Payment Voucher</button>
                  <h3 class="card-title">Payment Voucher</h3>
              </div>
              <!-- /.card-header -->

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
          <table id="purchase-order-table" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Select</th>
              <th>Requisition_no</th>
              <th>Purchase Order</th>
              <th>Prepared_by</th>
              <th>Actual Cost</th>
              <th>Department</th>
              <th>Institution</th>
              <th>Parish</th>
              <th>Supplier Name</th>
             
            </tr> 
            </thead>
            <tbody>
         
           @foreach($purchaseOrders as $purchase_order)
           <tr>
           <td> <a href="/payment-voucher/create/{{$purchase_order->id}}" class="btn btn-block btn-success btn-sm">Select</a> </td>
           <td>{{$purchase_order->requisition->requisition_no}}</td>
           <td>{{$purchase_order->purchase_order_no}}</td>
           <td>{{$purchase_order->user->firstname[0]}}.{{$purchase_order->user->lastname}}</td>
           <td>{{$purchase_order->requisition->contract_sum}}</td>
           <td>{{$purchase_order->requisition->department->name}}</td>
           <td>{{$purchase_order->requisition->institution->name}}</td>
           <td>{{$purchase_order->requisition->institution->parish->name}}</td>
           <td>{{$purchase_order->requisition->supplier->name}}</td>
          
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
                <table id="voucher_table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    
              <th>Requisition No.</th>
              <th>P.O No.</th>
              <th>Requested by</th>
              <th>Actual Cost</th>
              <th>Department</th>
              <th>Institution</th>
              <th>Voucher No. </th>
              <th>Cheque No.</th>
              <th>Cheque Date
              <th>Commitment</th>
              <th>Payee</th>
              <th>Terms</th>   
              <th>Created Date</th>    
              <th></th>    
              <th></th>                
                  </tr>
                  </thead>
                  <tbody>
              @foreach($vouchers as $voucher)
                    <tr>
                    
                    <td>{{$voucher->purchaseOrder->requisition->requisition_no}}</td>
                    <td>{{$voucher->purchaseOrder->purchase_order_no}}</td>
                    <td>{{$voucher->purchaseOrder->user->abbrName()}}</td>
                    <td>{{$voucher->purchaseOrder->requisition->contract_sum}}</td>
                    <td>{{$voucher->purchaseOrder->requisition->department->name}}</td>
                     <td>{{$voucher->purchaseOrder->requisition->institution->name}}</td> 
                    <td>{{$voucher->voucher_no}}</td>
                    <td>{{$voucher->cheque_no}}</td>
                    <td>{{$voucher->cheque_date}}</td>
                    <td>{{$voucher->purchaseOrder->requisition->commitment_no}}</td>
                    <td>{{$voucher->purchaseOrder->requisition->supplier->name}}</td>
                    <td>{{$voucher->purchaseOrder->requisition->delivery}}</td>
                    <td>{{Carbon\Carbon::parse($voucher->created_at)->format('Y-M-d')}}</td>
                    <td>
                     <a  href="/payment-voucher/{{$voucher->id}}/edit" class="btn btn-block btn-primary btn-m" >Edit</a> 
                    </td>
                    <td>
                    <a href="#" class="btn btn-block btn-danger btn-m" onclick="deleteVoucher({{$voucher->id}})" >Delete</a>
                    </td> 
                      
                    @endforeach
                    
                 
                 
                  </tbody>
                  
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
    $('#voucher_table').DataTable({
         "scrollX": true
    });
    
} );

$(document).ready( function () {
    $('#purchase-order-table').DataTable({
         "scrollX": true
    });
    
} );


function deleteVoucher(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/payment-voucher/delete/" + Id).then(function (data) {
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