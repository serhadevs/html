

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

    @section('content')
    <style type="text/css">
#second {
display:none;
}

#third{
  display:none;
}
.title{
text-align: center;
}


</style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
               <div class="container-fluid">
                  <section class="content-header">
        
              <div class="col-sm-10">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Voucher Check </h3>
                        </div>
                        </div>
                        </div>
          
                </section>
            
                <div class="card-body">

                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/voucher-check" >
                  @csrf --}}
                  
                      

                        <div class="col-m-10">
                        
                        <div class="md-card uk-margin-medium-bottom">
                        <div class="md-card-content">
                        <div class="uk-width-1-2 mb-2">
                        <div class="progress" style="height:40px; width:83%">    
                        <div class="progress-bar bg-danger rounded" role="progressbar" style="width:33.5%"id ="progressBar">
                        <b class="lead" id="progressText">page 1</b>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                      


                        <div id="first">
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                          <div class="col-m-10">
                          
                            <div class="form-group row">
                              <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->user->abbrName()}}" readonly>
                              
                            </div>
      
                              <label for="inputEmail4" class="col-sm-2 col-form-label">Department</label>
                              <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->department->name}}" readonly>
                              </div>
                            </div>
                                <div class="form-group row">
                              <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->institution->name}}" readonly>
                               
                                </div>
      
                              <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->internalrequisition->created_at}}" name='date_ordered' id="date-ordered" readonly>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="department" class="col-sm-2 col-form-label">Type</label>
                              <div class="col-sm-4">
                             
                                <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->internalrequisition->requisition_type->name}}"name='date_ordered' id="date-ordered" readonly>
                            
                            </div>
                              <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                              <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->procurement_method->name}}"name='procurement_method' id="procurement_method" readonly>
                                 
                              </div>
                            </div>
                            
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Recommended </label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->supplier->name}}"name='supplier' id="supplier" readonly>
                              
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Delivery</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->delivery}}"name='delivery' id="delivery" readonly>
                               
                               
                              </div>
                              </div>
      
      
      
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                              <div class="col-sm-4">
                                  <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->cost_centre}}" name='cost_centre' disabled>
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                              <div class="col-sm-4">
                               
                               <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->commitment_no}}" name='commitment' disabled>
                               
                              </div>
                              </div>
      
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                              <div class="col-sm-4">
                                  <input type="text" class="form-control" value = "{{$voucher->purchaseOrder->requisition->description}}" readonly name='description'>
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                              <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->category->name}}"name='category' id="category" readonly>
                              
                               
                              </div>
                              </div>
                              
                              
                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                              <div class="col-sm-4">
                                  <input type="number" class="form-control" value="{{$voucher->purchaseOrder->requisition->tcc}}" name='tcc' readonly>
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">TRN</label>
                              <div class="col-sm-4">
                               
                               <input type="number" class="form-control" value="{{$voucher->purchaseOrder->requisition->trn}}" name='trn' readonly>
                               
                              </div>
                              </div>
      
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                             
                              <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->tcc_expired_date}}" name='trn' readonly>
                              
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                              <div class="col-sm-4">
                               
                               <input type="number" class="form-control" value="{{$voucher->purchaseOrder->requisition->internalrequisition->estimated_cost}}" id= 'estimated_cost' name='estimated_cost' readonly>
                               
                              </div>
                              </div>
      
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                              <div class="col-sm-4">
                                  <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->contract_sum}}" id="contract_sum" name='contract_sum'readonly>
                              </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Cost Variance</label>
                              <div class="col-sm-4">
                               
                               <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                               
                              </div>
                              </div>
      
      
                         
                              
                               <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Date Required</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->date_require}}" id= 'estimated_cost' name='estimated_cost' readonly>
                             
                             </div>
                              <label for="date-of-last" class="col-sm-2 col-form-label">Date Last Order</label>
                              <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->date_last_ordered}}" id= 'estimated_cost' name='estimated_cost' readonly>
                              </div>
                              </div>
                         <div class="form-group row">
                      <label for="institute" class="col-sm-2 col-form-label">Purchase Order#</label>
                      <div class="col-sm-4">
                      <input type="input" class="form-control" readonly id ='purchase_order_no' name="purchase_order_no" value="{{$voucher->purchaseOrder->purchase_order_no}}">
                        </div>
                        </div>
                        <div class="form-group row">
                      <label for="institute" class="col-sm-2 col-form-label">Comments</label>
                      <div class="col-sm-4">
                      <textarea class="form-control" readonly name ="comments" id="comments" value="" rows="3" placeholder="Enter ...">{{$voucher->purchaseOrder->comments}}</textarea>
                        </div>
                        </div>

                        


                        </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-10">
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                       
                        <button type="button"  name="next-1" id="next-1" class="btn btn-success float-right">Next</button>
                        </div>
                        </div>

                        </div>

                      

           <div id="second">  
                      <!-- Editable table -->
                <div class="col-sm-10">
                <div class="card" >
                <div class="card-body">

                  <table id="table" class="table table-bordered table-responsive-md table-striped text-center">
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
               @foreach($voucher->purchaseOrder->requisition->internalrequisition->stocks as $stock)
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
          </table>
                 

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
            @foreach($voucher->purchaseOrder->requisition->files as $file)
            <tr> 
            <td>
            <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
            </td> 
          <td> <a class="btn btn-primary " href="{{ asset('/documents/'.$file->filename)}}">View</a></td>
            <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" >Remove</button></td>
          </tr>
            @endforeach 
          </tbody>
        </table>
      {{-- </form> --}}
      </div>
       </div> 
                    

                </div>
                </div>
    <!-- Editable table -->
                      
    </div>
   
                    


                        <div class="row">
                        <div class="col-10">
                        <button type="button"  id="previous" class="btn btn-primary">Previous</button>
                        <button type="button"  name="next-2" id="next-2" class="btn btn-success float-right" >Next</button>
                        </div>
                        </div>
                        </div>

                    <div id="third">
                      <div class="card" style="width:82.9%">
                        <div class="card-body">
                        <div class="col-m-10"> 
                        
                          
                          <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Voucher No.</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" readonly id='voucher_no' name="voucher_no" value="{{$voucher->voucher_no}}">
                            
                          </div>
    
                            <label for="inputEmail4" class="col-sm-2 col-form-label">Voucher Date</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control" id='voucher_no' readonly name="voucher_no" value="{{$voucher->voucher_date}}">
                            </div>
                            
                          </div>
                              <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Cheque No.</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$voucher->cheque_no}}" readonly id="cheque_no" name="cheque_no">
                             
                              </div>
    
                            <label for="inputEmail4" class="col-sm-2 col-form-label">Cheque Date</label>
                            <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$voucher->voucher_date}}" readonly id="cheque_no" name="cheque_no">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="department" class="col-sm-2 col-form-label">Commitment No.</label>
                            <div class="col-sm-4">
                           
                            <input type="input" class="form-control" readonly  value="{{$voucher->purchaseOrder->requisition->commitment_no}}"name='commitment' id="commitment" readonly>
                          
                          </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Payee</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" readonly value="{{$voucher->purchaseOrder->requisition->supplier->name}}" name='supplier' id="supplier" readonly>
                               
                            </div>
                          </div>
                          
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Voucher Description </label>
                            <div class="col-sm-4">
                            <textarea type="text" class="form-control" readonly name='description'>{{$voucher->description}}</textarea>
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Terms</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control"  value="{{$voucher->purchaseOrder->requisition->delivery}}"name='delivery' id="delivery" readonly>
                             
                             
                            </div>
                            </div>
    
                            
                            <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Institution </label>
                                <div class="col-sm-4">
                                    <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->institution->name}}" name='cost_centre' disabled>
                                </div>
                                {{-- <label for="date-of-last" class="col-sm-2 col-form-label">P.O.</label>
                                <div class="col-sm-4">
                                 
                                 <input type="input" class="form-control" value="" name='commitment' disabled>
                                 
                                </div> --}}
                                </div>
        
    
                             <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Req. No </label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$voucher->purchaseOrder->requisition->requisition_no}}" name='requisition_no' disabled>
                            </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">P.O.</label>
                            <div class="col-sm-4">
                             
                             <input type="input" class="form-control" value="{{$voucher->purchaseOrder->purchase_order_no}}" name='purchase_order_no' disabled>
                             
                            </div>
                            </div>


                            <div id="table" class="table-editable">
                             
                        <table id="stock-table" class="table table-bordered table-responsive-md table-striped text-center">
                          <thead>
                            <tr>
                              <th class="text-center">Invoice#</th>
                              <th class="text-center">Parish</th>
                              <th class="text-center">Institution</th>
                              <th class="text-center">NULL Value</th>
                               <th class="text-center">Account No.</th>
                              <th class="text-center">Amount</th>
                         
                            </tr>
                          </thead>
                        
                          <tbody>
                             @foreach($voucher->invoices as $invoice)
                             <div class="form-group row">
                             
                            <tr>

                             
                              <td>
                                
                              <input name='invoice_num[]' value="{{$invoice->invoice_no}}" class='invoice_num' id="invoice_num" type='text' size="5" style='border:none;outline:none;background: transparent;'>
                             
                              </td>
                              <td>
                              
                             
                                 {{$invoice->parish_code}}
                              </td>
                              <td>
                                 {{$invoice->institution_code}}
                              </td>
                              
                              <td>
                                  {{$invoice->value}}
                              </td> 
                              <td>
                                {{$invoice->account_no}}
                              </td>
                              <td>
                             {{$invoice->amount}}
                              </td>
                      
              
                            
                  
                            </tr>
                       
                          </div>
                        @endforeach
                          </tbody>
                         
                        </table>
              
                        <div class="row">
                          <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                              <label>Amount in words</label>
                              <textarea class="form-control"  name="amount_in_words" rows="3" readonly>{{$voucher->amount_in_words}}</textarea>
                            </div>
                          </div>
                          
                        </div>



                        
                      </div>

                       <div class="form-group row">
                      <div class="col-sm-6">
                    
                      Prepared by: <span class='badge badge-success'>{{$voucher->user->abbrName()}} </span>
                      </div>
                      <div class="col-sm-6">
                   
                       @if($voucher->voucherCheck)
                      Checked by: <span class='badge badge-success'> {{$voucher->voucherCheck->user->abbrName()}} </span>
                     
                        @endif
                   
                 
                      </div>
                    
                      </div> 


                        </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-10">
                        <button type="button"  id="previous-1" class="btn btn-primary">Previous</button>
                        
                        
                        @if($voucher->voucherCheck)
                        <button type="button"   class="btn btn-warning"  data-toggle="modal" data-target="#modal-lg" disabled>Refuse</button>
                        <button type="button"   class="btn btn-danger float-right" disabled>Confirm</button>
                        @else
                        <button type="button"   class="btn btn-warning"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        <button type="button"   class="btn btn-danger float-right" onclick="Accept('{{$voucher->id}}');">Confirm</button>
                        @endif
                      </div>
                        </div>
                        </div>
                      
                  

                

                      
                        {{-- //modal  --}}

                        <div class="modal fade" id="modal-lg">
                          <div class="modal-dialog modal-m">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Refuse Voucher Check</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                 <div class="card-body">
                                  <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/voucher-check" >
                                    @csrf 
                                     <div class="form-group row">
                                    <label for="cost-centre" class="col-m-4 col-form-label">Comments</label>
                                    <div class="col-m-8">
                                        <textarea type="text" style="width:400px; height:200px;" value="{{Request::old('comment')}}" id="comment" name='comment'></textarea>
                                    </div>
                                    <input type="hidden" name='voucher_id' id="voucher_id" value="{{$voucher->id}}"> 
                                    </div>
   

                                 
                                </form>

                        
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-primary float-right" id="post" onclick="Refuse('{{$voucher->id}}');">Send</button>
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        


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
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/editable-table.js"></script> 
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script src="/js/sweet/sweetalert.min.js"></script> 
    @endpush
      
    @push('scripts')
    <script>
    $(document).ready(function(){
$('#next-1').click(function(){
$('#second').show();
$('#first').hide();
$('#third').hide();
$('#progressBar').css("width","67%")
$('#progressText').html('page 2')
});


$('#next-2').click(function(){
    $('#first').hide();
    $('#second').hide();
    $('#third').show();
    $('#progressBar').css("width","100%")
    $('#progressText').html('page 3')

})

$('#previous').click(function(){
    $('#first').show();
    $('#second').hide();
    $('#progressBar').css("width","33.5%")
    $('#progressText').html('page 1')

})
$('#previous-1').click(function(){
    $('#first').hide();
    $('#third').hide();
    $('#second').show();

    $('#progressBar').css("width","67%")
    $('#progressText').html('page 2')

})

});



function Accept(voucherId){
   swal({
        title: "Are you sure you want to accept the selected applications?",
        text: "Tip: Always ensure that you review each page thoroughly before approval.",
        icon: "success",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/voucher-check",{ _method: "POST",data:{voucherId:voucherId,refuse:0,check:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Payment Voucher was accepted.",
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
                location.href='/voucher-check';
               
              });
            }
       
        });
}

function Refuse(voucherId){
  var comment = $('#comment').val();
  console.log(comment);
   swal({
        title: "Are you sure you want to refuse the selected applications?",
        // text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/voucher-check",{ _method: "POST",data:{voucherId:voucherId,refuse:1,check:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Voucher check was refuse and will send an email to the requester.",
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
                location.href='/voucher-check';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}

  






  </script>




  
 





    @endpush