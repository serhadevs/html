




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
            <h1>Edit Purchase Order</h1>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/purchase-order/{{$purchaseOrder->id}}"  enctype="multipart/form-data" " >
                  @csrf
                  @method('PATCH') 
                  
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p>
                        </div>
                              <h3 class="card-header text-center font-weight-bold text-uppercase py-1">Purchase Order</h3></br>
                
                     
                          <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$purchaseOrder->requisition->internalrequisition->user->abbrName()}}" readonly>
                              </div>
    
                            <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$purchaseOrder->requisition->department->name}}" readonly>
                            </div>
                          </div>
                              <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$purchaseOrder->requisition->institution->name}}" readonly>
                             
                              </div>
    
                            <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->internalrequisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="department" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-4">
                           
                              <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->internalrequisition->requisition_type->name}}"name='date_ordered' id="date-ordered" readonly>
                          
                          </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->procurement_method->name}}"name='procurement_method' id="procurement_method" readonly>
                               
                            </div>
                          </div>
                          
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Recommended </label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->supplier->name}}"name='supplier' id="supplier" readonly>
                            
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Delivery</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->delivery}}"name='delivery' id="delivery" readonly>
                             
                             
                            </div>
                            </div>
    
    
    
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                            <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$purchaseOrder->requisition->cost_centre}}" name='cost_centre' disabled>
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                            <div class="col-sm-4">
                             
                             <input type="input" class="form-control" value="{{$purchaseOrder->requisition->commitment_no}}" name='commitment' disabled>
                             
                            </div>
                            </div>
    
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value = "{{$purchaseOrder->requisition->description}}" readonly name='description'>
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$purchaseOrder->requisition->category->name}}"name='category' id="category" readonly>
                            
                             
                            </div>
                            </div>
                            
                            
                            <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{$purchaseOrder->requisition->tcc}}" name='tcc' readonly>
                            </div>
                            <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                           
                            <div class="col-sm-4">
                            <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                            <input type="text" class="form-control datepicker-input" name='tcc_expired_date' value="{{$purchaseOrder->requisition->tcc_expired_date}}" data-target="#tcc_expired" readonly/>
                            <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            </div>
                            
                            </div>
                            </div>
                            <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                              <div class="col-sm-4">
                                  <input type="number" class="form-control" value="{{$purchaseOrder->requisition->ppc}}" name='ppc' readonly>
                              </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='ppc_expired_date' value="{{$purchaseOrder->requisition->ppc_expired_date}}" data-target="#ppc_expired" readonly/>
                              <div class="input-group-append" data-target="#ppc_expired" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              </div>
                              
                              </div>
                              </div>
    
                             <div class="form-group row">
                              <label for="date-of-last" class="col-sm-2 col-form-label">Supplier TRN</label>
                              <div class="col-sm-4">
                               
                               <input type="number" class="form-control" value="{{$purchaseOrder->requisition->supplier->trn}}" name='trn' readonly>
                               
                              </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                            <div class="col-sm-4">
                             
                             <input type="number" class="form-control" placeholder="${{number_format($purchaseOrder->requisition->internalrequisition->estimated_cost,2)}}" id= 'estimated_cost' name='estimated_cost' readonly>
                             
                            </div>
                            </div>
    
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" placeholder="${{number_format($purchaseOrder->requisition->contract_sum,2)}}" id="contract_sum" name='contract_sum'readonly>
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Cost Variance</label>
                            <div class="col-sm-4">
                             
                             <input type="number" class="form-control" value="{{$purchaseOrder->requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                             
                            </div>
                            </div>
                            @if($purchaseOrder->requisition->advertisement_method != null)
                                <div class="form-group row">
                                  <label for="advertisement_method" class="col-sm-2 col-form-label">Method of advertisement </label>
                                  <div class="col-sm-4">
                                  <select type="input" class="form-control" name="advertisement_method" id="advertisement_method" readonly required>
                                    <option value="{{$purchaseOrder->requisition->advertisement_method->id}}">{{$purchaseOrder->requisition->advertisement_method->name}}</option>
                                  </select> 
                                  </div>
                                  <label for="tender_opening" class="col-sm-2 col-form-label">Tender Opening</label>
                                  <div class="col-sm-4">
                                  <span style="position: absolute; margin-left: 1px; margin-top: 6px;"></span>
                                  <input type="date" value= "{{$purchaseOrder->requisition->tender_opening}}"class="form-control" id="tender_opening" name='tender_opening' readonly required>
                                  </div>
                                  </div>
                                  <div class="form-group row">
                                  <label for="tender_from" class="col-sm-2 col-form-label">Tender Period From</label>
                                  <div class="col-sm-4">
                                  <input type="date"  class="form-control" value= "{{$purchaseOrder->requisition->tender_from}}" id="tender_from" name='tender_from' readonly  required>
                                  </div>
                                  <label for="tender_to" class="col-sm-2 col-form-label">Tender Period To</label>
                                  <div class="col-sm-4">
                                  <input type="date" class="form-control" value= "{{$purchaseOrder->requisition->tender_to}}" id="tender_to" name='tender_to' readonly  required>
                                  </div>
                                  </div>
                                  <div class="form-group row">
                                  <label for="cost-centre" class="col-sm-2 col-form-label">Tender Bond Request</label>
                                  <div class="col-sm-4">
                                  <select type="input" class="form-control" name="tender_bond" id="tender_bond" readonly  required>
                                    <option selected value={{$purchaseOrder->requisition->tender_bond}}>{{$purchaseOrder->requisition->tender_bond ===1 ? "Yes":"No" }}</option>
                                  </select> 
                                  </div>
                                  <label for="number_days" class="col-sm-2 col-form-label">Number of days</label>
                                  <div class="col-sm-4">
                                  <input type="number" class="form-control" value= "{{$purchaseOrder->requisition->number_days}}" id="number_days" name='number_days' readonly required>
                                  </div>
                                  </div>
                                  
                                  <div class="form-group row">
                                  <label for="bid_request" class="col-sm-2 col-form-label">Bid Request</label>
                                  <div class="col-sm-4">
                                  <input type="number" class="form-control" value= "{{$purchaseOrder->requisition->bid_request}}" id="bid_request" name='bid_request' readonly  required>
                                  </div>
                                  <label for="bid_received" class="col-sm-2 col-form-label">Bid Received</label>
                                  <div class="col-sm-4">
                                  <input type="number" class="form-control" value= "{{$purchaseOrder->requisition->bid_received}}" id="bid_received" name='bid_received' readonly  required>
                                  </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bid_val" class="col-sm-2 col-form-label">Bid Validity</label>
                                    <div class="col-sm-4">
                                    <input type="number" class="form-control" value= "{{$purchaseOrder->requisition->validity}}" id="validity" name="validity" readonly  required>
                                    </div>
                                    <label for="bid_received" class="col-sm-2 col-form-label">Expiration Date</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control" value= "{{$purchaseOrder->requisition->expiration_date}}" id="expiration_date" name="expiration_date" readonly required>
                                    </div>
                                    </div>
                                  
                                    {{-- <div class="form-group row">
                                    <label for="transport" class="col-sm-2 col-form-label">Transport Cost</label>
                                    <div class="col-sm-4">
                                    <input type="number" class="form-control" value= "{{$requisition->transport_cost}}" id="transport_cost" name="transport_cost" readonly  required>
                                    </div>
                                  
                                    <div class="col-sm-4">
                                    
                                    </div>
                                    </div> --}}
                                    @endif
    
                       
                            
                            
                           <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Purchase Order#</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" id ='purchase_order_number' name="purchase_order_number" value="{{$purchaseOrder->purchase_order_no}}"required>
                          </div>
                          <label for="requisition" class="col-sm-2 col-form-label">Requisition no.</label>
                          <div class="col-sm-4">
                          <input type="input" class="form-control" name="requisition_no" value="{{$purchaseOrder->requisition_no}}" readonly>
                            </div>
                          </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Comments</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" name ="comments" id="comments" value="" rows="3" placeholder="">{{$purchaseOrder->comments}}</textarea>
                          </div>
                        </div>
                       
                        {{-- <div class="form-group row">
                        <div class="col-sm-6">
                      
                    
                        <h3 class="card-title">Recommended Supplier</h3>
                        <input type="text" class="form-control" value="{{$requisition->supplier->name}}" readonly >
                        </div>
                 
                     
                        <div class="col-sm-6">
                  
                     
                        <h3 class="card-title"> Supplier Address</h3>
                        <input type="text" class="form-control" id="inputEmail3" value="{{$requisition->supplier->address}}" readonly>
                   
                        </div>
                      
                        </div> --}}
                        </p>

                <div class="col-sm-14">
                {{-- <div class="card" > --}}
                {{-- <div class="card-body"> --}}
                
              
    
          {{-- <table id="table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Part Number</th>

              
                
              </tr>
            </thead>
            <tbody>
               @foreach($requisition->internalrequisition->stocks as $stock)
              <tr>
                
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->unit_of_measurement_id}}</td>
                <td>{{$stock->unit_cost}}</td>
                <td>{{$stock->part_number}}</td>

              
              </tr>
               
           @endforeach
          
            </tbody>
          </table> --}}
           {{-- <div class="form-group row">

            <div class="col-sm-8">
               
            <input name='requisition_id' id="requisition_id"  value = {{$requisition->id}} type='hidden' size="5" style='width:80px;border:none;outline:none;background: transparent;'  readonly></td>
            </div>    
          <div class="col-sm-4">
           <table style="margin-right:auto;margin-left:0px" class="table table-bordered table-responsive-md table-striped text-left">
          <tr>
          <th>Subtotal</th>
          <td> <input name='subtotal' id="subtotal" type='number' value="{{$purchaseOrder->subtotal}}" size="5" style='width:80px;border:none;outline:none;background: transparent;' value="{{$requisition->total}}" readonly></td>
          </tr>  
          <tr>
          <th>Trade_Discount</th>
           <td> <input name='trade_discount' id="trade_discount" value='{{$purchaseOrder->trade_discount}}' type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr>  
          <tr>
          <th>Freight</th>
           <td> <input name='freight' id="freight" type='number' value='{{$purchaseOrder->freight}}' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr>  
          <tr>
          <th>Miscellaneous</th>
           <td> <input name='miscellaneous' id="miscellaneous" value='{{$purchaseOrder->miscellaneous}}' type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' required></td>
          </tr> 
          <tr>
          <th>Tax</th>
          <td> <input name='tax' id="tax" type='number' size="5" value ='{{$purchaseOrder->tax}}' style='width:80px;border:none;outline:none;background: transparent;' required></td>
          
          </tr>   

          <tr>
          <th>Order Total</th>
          <td> <input name='order_total' id="order_total" value="{{$purchaseOrder->order_total}}" type='number' size="5" style='width:80px;border:none;outline:none;background: transparent;' readonly></td>
          
          </tr>   
      
          </table>
        </div>
      </div>
     --}}
                      
    </div>
<div class="row">
    <div class="col-sm-6">
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
@foreach($purchaseOrder->requisition->files as $file)
<tr> 
<td>
<input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
</td> 
<td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
<td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled >Remove</button></td>
</tr>
@endforeach
</tbody>
 <tbody>
                    @foreach($purchaseOrder->requisition->internalrequisition->attached as $file)
                    <tr> 
                    <td>
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                  </tr>
                    @endforeach
                  </tbody>

<tbody>
                    @foreach($purchaseOrder->attached as $file)
                    <tr> 
                    <td>
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                  </tr>
                    @endforeach
                  </tbody>
</table>
{{-- </form> --}}
</div>
</div> 
</div>
</br>
<p>
 
</p>  

<div class="form-group row">
  <div class="col-sm-6">
    Approve IRF by: <span class='badge badge-success'>{{$purchaseOrder->requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$purchaseOrder->requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
  
    Accepted by: <span class='badge badge-success'>{{$purchaseOrder->requisition->check->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$purchaseOrder->requisition->check->created_at}}</span></br>
  </div>
  <div class="col-sm-6">
    

  
    Date:<span class='badge badge-success'>{{$purchaseOrder->requisition->approve->created_at}}</span></br>
    Prepared PO by: :<span class='badge badge-success'>  <b>{{$purchaseOrder->requisition->purchaseorder->user->firstname[0]}}. {{$purchaseOrder->requisition->user->lastname}}</span></b> </br>
    Date:<span class='badge badge-success'>  <b>{{$purchaseOrder->created_at}}</span></b> </br>               
    @if(isset($purchaseOrder->requisition->approve))
    @if($count > 1)
                          @foreach($purchaseOrder->requisition->approve->where('requisition_id',$purchaseOrder->requisition->id)->get() as $key=> $approve)
                          {{($key ===0) ? ('CEO') : (($key ===1) ? ('Parish Manager') : ('Director of Procurement'))}} : <span class='badge badge-success'> {{$approve->user->abbrName()}}</span></br>
                           Date:<span class='badge badge-success'>{{$approve->created_at}}</span></br>
                          @endforeach
                         
    @else
    Approve Requisition by:  <span class='badge badge-success'>{{$purchaseOrder->requisition->approve->user->abbrName()}}</span></br>
    @endif
    @endif

  </div>

  </div> 
              </div>
              <!-- /.card-body -->
              
              
            </div>
            <!-- /.card -->
            
            
          </div>
         
        </div>

<div id="get_name"></div>
      <div class="row">
                       
                       
                        
                      
                        <div class="col-10">
                        <a type="button" href="/purchase-order"   class="btn btn-outline-success float-left btn-lg">Back</a>
                     
                        <button type="submit"  class="btn btn-outline-primary float-right btn-lg">Update</button>
                        </div>
      </div>
                        <br>

      </div>
          </form>  
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


$('#tax ,#freight ,#trade_discount ,#miscellaneous, #subtotal' ).on('input',function(){
var tax = parseInt($('#tax').val());
var freight = parseInt($('#freight').val());
var trade_discount = parseInt($('#trade_discount').val());
var miscellaneous = parseInt($('#miscellaneous').val());
var subtotal =parseInt($('#subtotal').val()); 
console.log(subtotal);
$('#order_total').val((subtotal +tax + freight + trade_discount + miscellaneous  ? subtotal + tax + freight + trade_discount + miscellaneous : 0).toFixed(2));

});


</script>

@endpush

