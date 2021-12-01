




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}

input[type="checkbox"]{
  width: 20px; /*Desired width*/
  height: 20px; /*Desired height*/
  /* cursor: pointer;
  -webkit-appearance: none;
  appearance: none;
   */
}


</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Purchase Order</h1>
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
              {{-- <div class="card-header">
                  
                  <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a>
                <h3 class="card-title">A list of all procurement requisition </h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
                  @csrf --}}
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th> </th>
                    <th>Aproval</th>
                    <th>Requisition_no</th>
                    <th>Date Receive</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    <th>Cost Centre</th>
                    <th>Commitment #</th>
                    <th>Tax</th>
                    <th>Order Total</th>
                    <th>Option</th>
                    <th></th>
                    {{-- <th></th> --}}
              
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($purchaseOrders as $purchaseOrder)
                    <tr>
                       <td>
                  
                        <input type="checkbox" name="selected_items[]" value="{{$purchaseOrder->id}}" data-md-icheck/> 
                        
                    </td>

                    
                    {{-- <td>{{$requisition->id}}</td> --}}
                    @if($purchaseOrder->approvePurchaseOrder)
                    <td> <span class ="badge bg-green">Approve</span></td>
                    @else
                    <td> <span class ="badge bg-red">unapprove</span></td>
                    @endif
                  <td>{{$purchaseOrder->requisition->requisition_no}}</td>
                  <td>{{$purchaseOrder->created_at}}</td>
                  <td>{{$purchaseOrder->requisition->department->name}}</td>
                  <td>{{$purchaseOrder->requisition->institution->name}}</td>
                  <td>{{$purchaseOrder->requisition->institution->parish->name}}</td>
                  <td>{{$purchaseOrder->requisition->supplier->name}}</td>
                  <td>{{$purchaseOrder->requisition->cost_centre}}</td>
                  <td>{{$purchaseOrder->requisition->commitment_no}}</td>
                  <td>{{$purchaseOrder->tax}}</td>
                  <td>{{$purchaseOrder->order_total}}</td>
                  
                    {{-- <td>
                      @if(!$purchaseOrder->approvePurchaseOrder) 
                    <button  class="btn btn-block btn-primary btn-sm"  id ="approve" onclick="ApprovePurchaseOrder('{{$purchaseOrder->id}}');">Approve</button> </td> 
                      @else
                    <button  class="btn btn-block btn-primary btn-sm"  id ="approve" disabled onclick="ApprovePurchase('{{$purchaseOrder->id}}');">Approve</button> </td>
                     @endif --}}
                     
                     {{-- <button  class="btn btn-block btn-primary btn-sm"  id ="checks" type='submit'>check</button> </td>  --}}
                    <td> <a href="/approve-purchase-order/{{$purchaseOrder->id}}" class="btn btn-block btn-success btn-sm">View</a>
                      <td> <a href="" class="btn btn-block btn-danger btn-sm">Remove</a>
                    </td> 


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
         "scrollX": true,
         deferRender:true,
         select: true,
         columnDefs: [
    {
        targets: -1,
        className: 'dt-body-right'
    }
  ]
    });
    
} );



  // $.get( {!! json_encode(url('/')) !!} + "/foodhandlers/delete/" + permitId).then(function (data) 
 // $.post( {!! json_encode(url('/sign-off/approve')) !!}, { _method: "POST", data: {selected_items: selected_items, appTypeId: appTypeId}, _token: "{{ csrf_token() }}" }).then(function (data)
function ApprovePurchaseOrder(purchase_id){
   
        swal({
        title: "Are you sure you want to approve the selected applications?",
        text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          console.log("approve");
          $.post( {!! json_encode(url('/')) !!} + "/approve-purchase-order",{ _method: "POST",data:{purchase_id:purchase_id},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was approve and will shortly be forwarded for purchase order.",
                "success").then(esc => {
                  if(esc){
                    location.reload();
                  }
                });
              }else{
                swal(
                  "Oops! Something went wrong.",
                  "Application(s) were NOT approved",
                  "error");
                }
              });
            }
       
        });
}



 


</script>

@endpush

