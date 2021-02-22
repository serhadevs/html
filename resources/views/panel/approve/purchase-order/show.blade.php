




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}

.title{
text-align: center;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Approve Purchase Order</h1>
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
              
          <div class="col-10">
            <div class="card">
              {{-- <div class="card-header">
                  
                  <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a>
                <h3 class="card-title">A list of all procurement requisition </h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p><br>
                        </div>

                      Requester:  <b>{{$requisition->user->firstname[0]}}. {{$requisition->user->lastname}}</b>

                        <p><br>Institution: {{$requisition->institution->name}}</br>
                          Departmentent: {{$requisition->department->name}} </br>
                          Cost Centre: {{$requisition->cost_centre}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}
                         
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Requisition Type: {{$requisition->requisition_type->name}}</br>  
                        Cost Centre: {{$requisition->cost_centre}}</br>
                        Description: {{$requisition->description}}</br>
                        TCC Number: {{$requisition->tcc}}</br>
                        TCC Expired: {{$requisition->tcc_expired_date}}</br>
                        Contract Sum: {{$requisition->contract_sum}}</br>
                        Date Required: {{$requisition->date_require}}</br>
                        </div>
                        
                        <div class="col-sm-6">
                        Procurement Method: {{$requisition->procurement_method->name}}</br>
                        Commitment: {{$requisition->commitment_no}}</br>
                        Category: {{$requisition->category->name}} </br>
                        TRN: {{$requisition->trn}}</br>
                        Estimate Cost: {{$requisition->estimated_cost}} </br>
                        Cost Variance: {{$requisition->cost_variance}} </br>
                        Date Last Order: {{$requisition->date_last_ordered}} </br>
                        

                        </div>
                        </div>
                        </p> 
                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                      
                    
                        <h3 class="card-title">Recommended Supplier</h3>
                        <input type="text" class="form-control" value="{{$requisition->supplier->name}}" readonly >
                        </div>
                 
                     
                        <div class="col-sm-6">
                  
                     
                        <h3 class="card-title"> Supplier Address</h3>
                        <input type="text" class="form-control" id="inputEmail3" value="{{$requisition->supplier->address}}" readonly>
                   
                        </div>
                      
                        </div>
                        </p>
                          
                <div class="col-m-12">
                {{-- <div class="card" > --}}
                {{-- <div class="card-body"> --}}
                {{-- <h3 class="card-header text-center font-weight-bold text-uppercase py-4">requisitions</h3> --}}
              
    
          <table id="table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Product Name</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Description</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Measurement</th>
                <th class="text-center">Categories</th>
                 <th class="text-center">Total</th>


              
                
              </tr>
            </thead>
            <tbody>
               @foreach($requisition->stock as $stock)
              <tr>
              
                <td>{{$stock->product_name}}</td>
                <td>{{$stock->quantity}}</td>
              <td>{{$stock->description}}</td>
                <td>{{$stock->unit_cost}}</td>
                {{-- <td>{{$stock->unit}}</td> --}}
                <td>{{$stock->unit_of_measurement->name}}</td>
                <td>{{$stock->stock_category->name}}</td>
                <td>{{$stock->quantity * $stock->unit_cost}}</td>
                  {{-- <td>{{$stock->filename}}</td> --}}

              
              </tr>
               
           @endforeach
           {{-- <tr>
              <th>Grand Total</th> 
              <td></td> 
              <td></td> 
              <td></td> 
              <td></td>
              <td></td>
           <td>{{$requisition->total}}</td>  
          </tr>   --}}
            </tbody>
          </table>
     
      {{-- </div> --}}
    {{-- </div> --}}
    <!-- Editable table -->
                      
    </div>


 <div class="form-group row">

            <div class="col-sm-8">
                            <label for="exampleInputFile">Support Documents</label>
                       <div class="card-body p-0">
                  {{-- <form  method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}" >
                  @csrf
                  @method('delete')  --}}
                <table class="table table-sm" id="filetable">
                  <thead>
                    <tr>
                      <th>Filename</th>
                      <th>Option</th>
                      <th><th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(App\File_Upload::where('requisition_id',$requisition->id)->get() as $file)
                    <tr> 
                    <td>
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('/documents/'.$file->filename)}}">View</a></td>
                    <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled>Remove</button></td>
                  </tr>
                    @endforeach
                  </tbody>
                </table>
              {{-- </form> --}}
              </div>
               </div> 
                <br>
          <br>
          <div class="col-sm-4">
           <table style="margin-right:auto;margin-left:0px" class="table table-bordered table-responsive-md table-striped text-left">
          <tr>
          <th>Subtotal</th>
          <td> <input name='subtotal' id="subtotal" type='number' value="{{$requisition->purchase_order->subtotal}}" size="5" style='width:80px;border:none;outline:none;background: transparent;' value="{{$requisition->total}}" readonly></td>
          </tr>  
          <tr>
          <th>Trade_Discount</th>
           <td> <input name='trade_discount' id="trade_discount" value='{{$requisition->purchase_order->trade_discount}}' type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr>  
          <tr>
          <th>Freight</th>
           <td> <input name='freight' id="freight" type='number' value='{{$requisition->purchase_order->freight}}' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr>  
          <tr>
          <th>Miscellaneous</th>
           <td> <input name='miscellaneous' id="miscellaneous" value='{{$requisition->purchase_order->miscellaneous}}' type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr> 
          <tr>
          <th>Tax</th>
          <td> <input name='tax' id="tax" type='number' size="5" value ='{{$requisition->purchase_order->tax}}' style='width:80px;border:none;outline:none;background: transparent;' required></td>
          
          </tr>   

          <tr>
          <th>Order Total</th>
          <td> <input name='order_total' id="order_total" value="{{$requisition->purchase_order->order_total}}" type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' readonly></td>
          
          </tr>   
      
          </table>
        </div>

                           <div class="col-10">
                        <div class="col-sm-5">
                      
                        Accepted by: <span class='badge badge-success'> {{$requisition->check->user->firstname[0]}}. {{$requisition->check->user->lastname}} </span>
                        </div>
                        <div class="col-sm-5">
                      
                        Approve Requisition by: <span class='badge badge-success'>{{$requisition->approve->user->firstname[0]}}. {{$requisition->check->user->lastname}} </span>
                        </div>
                        <div class="col-sm-5">
                         @if($requisition->purchase_order->approvePurchaseOrder)
                        Approve Purchase Order by: <span class='badge badge-success'>{{$requisition->purchase_order->approvePurchaseOrder->user->firstname[0]}}. {{$requisition->purchase_order->approvePurchaseOrder->user->lastname}} </span>
                          @endif
                        </div>
                      </div>

      </div>
                      
                  </div>

     
      
          
                       
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                          @if($requisition->purchase_order->approvePurchaseOrder)
                          <button type="button"   class="btn btn-warning" disabled>Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"  onclick="ApprovePurchaseOrder('{{$requisition->purchase_order->id}}');" disabled>Approve</button></br>
                        @else
                        <button type="button"   class="btn btn-warning">Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"  onclick="ApprovePurchaseOrder('{{$requisition->purchase_order->id}}');">Approve</button></br>
                       

                        @endif
                      </div>
                       
                        </div>
                      </br>





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

function ApprovePurchaseOrder(purchase_id){
   
        swal({
        title: "Are you sure you want to approve the selected purchase order?",
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
                "Purchase order was approve and will shortly be forwarded to Accounts.",
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

