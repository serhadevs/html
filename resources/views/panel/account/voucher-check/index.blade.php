

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Checked</h1>
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
                 
                  <h3 class="card-title">Voucher Checked</h3>
              </div>
              <!-- /.card-header -->

                       {{-- modal started --}}


              <div class="card-body">
                <table id="voucher_table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
              <th>Check</th>      
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
              <th>View</th>                
                  </tr>
                  </thead>
                  <tbody>
               @foreach($vouchers as $voucher)
                    <tr>
                      @if($voucher->voucherCheck)
                      @if($voucher->voucherCheck->is_check==1)
                    <td> <span class ="badge bg-green">Accepted</span></td>
                    @elseif($voucher->voucherCheck->is_refuse==1)
                    <td> <span class ="badge bg-red">Refuse</span></td>
                    @endif
                    @else
                    <td> <span class ="badge bg-blue">Not Check</span></td>
                    @endif
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
                    <a  href="/voucher-check/show/{{$voucher->id}}" class="btn btn-block btn-primary btn-m" >View</a> 
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



</script>

@endpush