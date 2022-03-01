

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

    @section('content')
    <style type="text/css">
/* #second {
display:none;
}

#third{
  display:none;
}
.title{
text-align: center;
} */

.hide{
  display:none;
}

.above{
  display:none;
}

</style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
               <div class="container-fluid">
                  <section class="content-header">
        
              <div class="col-sm-12">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Create Purchase Requisition</h3>
                        </div>
                        </div>
                        </div>
                        
                        @if(count($errors)>0)
                        <div class="col-sm-12">
                  <div class="alert alert-danger">
                   {{-- <a class="alert alert-danger-close"></a> --}}


                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
              </div>
            @endif     
                </section>
            
                <div class="card-body">

                <form class="form-horizontal" id="requisition_form" method="Post" autocomplete="off" action="/requisition" enctype="multipart/form-data">
                  @csrf
                  
                      

                        {{-- <div class="col-m-10">
                        
                        <div class="md-card uk-margin-medium-bottom">
                        <div class="md-card-content">
                        <div class="uk-width-1-2 mb-2">
                        <div class="progress" style="height:40px; width:83%">    
                        <div class="progress-bar bg-danger rounded" role="progressbar" style="width:33.5%"id ="progressBar">
                        <b class="lead" id="progressText">Step -1</b>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div> --}}
                      


                 
                            <div class="card" style="width:100">
                          <div class="card-body">
                           <div class="col-m-12">
                           

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$internalrequisition->user->abbrName()}}" readonly>
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{$internalrequisition->department->name}}" readonly>
                        </div>
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$internalrequisition->institution->name}}" readonly>
                        <input type="hidden" name='requisition_no' id="requisition_no" value="{{$internalrequisition->requisition_no}}">
                        <input type="hidden" name='id' id="id" value="{{$internalrequisition->id}}"> 
                      </div>
                    
                        <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{($internalrequisition->created_at)->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                        </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                       
                          <input type="input" class="form-control"  value="{{$internalrequisition->requisition_type->name}}"name='requisition_type' id="requisition_type" readonly>
                      
                      </div>
                      <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                      <div class="col-sm-4">
                       <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                        <input type="number" class="form-control" value="{{$internalrequisition->estimated_cost}}" readonly id= 'estimated_cost' name='estimated_cost' read>
                       
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$internalrequisition->institution->code}}" readonly name='cost_centre' >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                        <div class="col-sm-4">
                         
                        <input type="input" class="form-control" value="{{$internalrequisition->budget_commitment->commitment_no}}" readonly name='commitment' id='commitment'>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                              <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$internalrequisition->requisition_no}}" readonly>
                                </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Terms</label>
                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="delivery" id="delivery"required>
                          <option value=""  >Select specification </option>
                          <option value="COD">COD</option>
                           <option value="Credit">Credit</option>
                           
                         </select>  
                       
                         
                        </div>
                              
                            </div>
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Recommend Supplier </label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control"name ='supplier_id' id="supplier" required>
                        <option value=''>Select supplier</option>
                         @foreach($suppliers as $supplier) 
                 
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        
                        @endforeach 
                        </select>
                        </div>

                        <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Address</label>
                        <div class="col-sm-4">
                         
                         <input type="text" class="form-control"  id='address' name='address' readonly>
                         
                        </div>
                       
                        </div>
                        <div class="form-group row">
                          <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                         
                          <div class="col-sm-4">
                            <select type="input" class="form-control" name="currency_type" id="currency_type" readonly required>
                              <option  selected value="{{$internalrequisition->currency->id}}">{{$internalrequisition->currency->abbr}} </option>
                          {{-- @foreach($currencies as $currency)
                          <option value="{{$currency->id}}">{{$currency->abbr}}</option>
                           @endforeach --}}
                             </select>  
                           </select> 
                          
                          </div> 
                          <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                          <div class="col-sm-4">
                           <select type="input" class="form-control" name="tax" id="tax" required>
                            <option>Select tax</option>
                            <option value=1>Yes</option>
                            <option value=0>No</option>
                           
                           </select>  
                          
                           
                          </div>
                          </div>



                       

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" value="{{Request::old('description')}}" name='description' required></textarea>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-4">
                         
                        <select type="input" class="form-control"name ='category' id="category" required>
                        <option value="" >select</option>
                        @foreach ($categories as $category)
                        <option name='category[]' value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        </select>
                         
                        </div>
                        </div>
                        <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                          <div class="col-sm-4">
                          <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                              <input type="number" class="form-control"  id="contract_sum" name='contract_sum' readonly required>
                          </div>
                          <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                        <div class="col-sm-4">
                           <select type="input" class="form-control" name="procurement_method" id="rocurement_method" required>
                          <option value="">Select method </option>
                      @foreach($methods as $method)
                      <option value="{{$method->id}}">{{$method->name}}</option>
                       @endforeach
                         </select>  
                       
                        </div>
                          </div>

                          {{-- <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Date Required</label>
                            <div class="col-sm-4">
                              {{-- <input type="text" class="form-control"  name="cost_centre" id="cost_centre" placeholder="Enter cost-centre"> --}}
                           {{-- <div class="input-group date" id="date_require" data-target-input="nearest">
                            <input type="text" class="form-control datepicker-input" name='date_require' data-target="#date_require"/>
                            <div class="input-group-append" data-target="#date_require" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                             </div> 
                           </div>
                            <label for="date-of-last" class="col-sm-2 col-form-label">Date Last Order</label>
                            <div class="col-sm-4">
                              <div class="input-group date" id="date_last_ordered" data-target-input="nearest">
                            <input type="text" class="form-control datepicker-input" name='date_last_ordered' data-target="#date_last_ordered"/>
                            <div class="input-group-append" data-target="#date_last_ordered" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                             </div>
                            </div>
                            </div> --}} 
                        
                       <div class='above'>

                        <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" value="{{Request::old('tcc')}}" name='tcc'>
                        </div>
                        <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                        <input type="text" class="form-control datepicker-input" name='tcc_expired_date' id='tcc_expired_date' value='{{Request::old('tcc_expired_date')}}' data-target="#tcc_expired"/>
                        <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        </div>
                        
                        </div>
                        
                        </div>

                         <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                          <div class="col-sm-4">
                              <input type="number" class="form-control" value="{{Request::old('pcc')}}" name='ppc'>
                          </div>
                        <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                        <input type="text" class="form-control datepicker-input" name='ppc_expired_date' id='ppc_expired_date' value='{{Request::old('ppc_expired_date')}}' data-target="#ppc_expired"/>
                        <div class="input-group-append" data-target="#ppc_expired" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        </div>
                        
                        </div>
                        
                        </div>

                       


                       </div>

                      <div class="form-group row">
                        <label for="date-of-last" class="col-sm-2 col-form-label">Percentage Variance</label>
                        <div class="col-sm-4">
                         
                         
                         <input type="number" class="form-control" value="" id='cost_variance' name='cost_variance' readonly>
                        </div>

                        <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Trn</label>
                        <div class="col-sm-4">
                         
                         <input type="text" class="form-control"  id='trn' name='trn' readonly>
                         
                        </div>
                        
                        </div>

                           <div class="row">
                             <div class="col-sm-12">
                       
                
          <table id="stock-table" class="table table-bordered  text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                {{-- <th class="text-center">Unit Cost</th>
                <th class="text-center">Estimated Total</th> --}}
                <th class="text-center">Actual Unit Cost</th>
                <th class="text-center">Total</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($internalrequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td><input name='quantity[]'  class='quantity' type='number' value={{$stock->quantity}} size="5"style='width:60px;border:none;outline:none;background: transparent;' readonly required></td>
                <td>{{$stock->unit_of_measurement->name}}</td>
                {{-- <td>{{$stock->unit_cost}}</td>
                <td> {{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2) }}</td> --}}
                <td>
                  <input name='actual_cost[]' id="actual_cost" size="5" id="" class='actual_cost' min="0.00" step="any"  type='number'style='width:80px; border:blue;outline:blue;background:white;' required>
                </td>
                <td>
                  <input name='actual_total[]' id="actual_total" size="5" id="" class='actual_total' min="0.00" step="any"  type='number'style='width:80px; border:blue;outline:none;background: transparent;' readonly required>
                </td>
       
              
              </tr>
               
           @endforeach
         
  
            </tbody>
          </table>
        </div>
        </div>
        <div class="row">
      <div class="col-sm-8">
             
      </div>

                         
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  style='width:1px;'>Sub Total</td>
    <td style='width:20px;'><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="0.0" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td style='width:20px;'>Sales Tax (15.0%)</td>
     <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="0.0" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td  style='width:20px;'>Grand Total</td>
     <td style='width:20px;'><input id='grandtotal' readonly type='text' value="0.0" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
        
                        <div class="row">
                          {{-- <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                              <label>Comments/Justification</label>
                            <textarea  readonly class="form-control" name="comments" rows="3" placeholder=""></textarea>
                            </div>
                          </div> --}}
              
              
              
                          @if($internalrequisition->comment->isNotEmpty())
                          <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                              <label>Refusal Comments</label>
              <textarea class="form-control" rows="3" disabled>
  @foreach($internalrequisition->comment as $comment)
  {{$comment->user->abbrName()}}: {{$comment->comment}}
  @endforeach
              </textarea>
                            </div>
                          </div>
                          @endif
                          @if($internalrequisition->attached->isNotEmpty())
                           <div class="col-sm-6">
                            <label for="exampleInputFile">Attached Files</label>
                       <div class="card-body p-0">
                  {{-- <form  method="Post" autocomplete="off" action="/requisition/{{$internalrequisition->id}}" >
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
                    @foreach($internalrequisition->attached as $file)
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
               @endif
                          
                        </div>        
              
                        <div class="form-group row img_div ">
                        <div class="col-sm-6">
                       
                     
                       <label for="exampleInputFile">Support Documents</label>
                       <div class="input-group">
                       <div class="custom-file">
                      <input type="file" name="file_upload[]" class="form-control" id="file_upload" accept="docs/*">
                      </div>
                      <div class="input-group-append">
                      <button class="btn btn-default btn-add-more" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                      </div>
                      </div>
                     
                      </div> 
                      </div> 



                      <div class ='hide'>
                      <div class="form-group row">
                      <div class="col-sm-6">
  
                      <div class="input-group">
                      <div class="custom-file">
                      <input type="file" name="file_upload[]" class="form-control" id="file_upload">

                      </div>
                      <div class="input-group-append">
                      <button class="btn btn-default btn-remove" type="button"><i class="glyphicon glyphicon-plus"></i>Remove</button>
                      </div>
                      </div>
                      </div>



                      </div>
                      </div>
                        







                        {{-- column length end --}}
                        </div>
                         <div class="form-group row">
                      <div class="col-sm-6">
                        @if(isset($internalrequisition->approve_internal_requisition))
                        Approve IRF by: <span class='badge badge-success'>{{$internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$internalrequisition->approve_internal_requisition->created_at}}</span></br>
                      @else
                      Approve IRF by:</br>
                      Date:
                        @endif
                      </div>
                      <div class="col-sm-6">
                        Budget Approve by: <span class='badge badge-success'>{{$internalrequisition->approve_budget->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalrequisition->approve_budget->created_at}}</span><br>
                        
                        
                              Budget Commitment by: <span class='badge badge-success'>{{$internalrequisition->budget_commitment->user->abbrName()}} </span></br>
                              Date:  <span class='badge badge-success'>{{$internalrequisition->budget_commitment->created_at}}</span>
                  
                 
                      </div>
                    
                      </div> 
            
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-12">
                        <button type="submit" id="btnSubmit" class="btn btn-block btn-outline-primary btn-lg">Submit</button>
                        </div>
                        </div>

                     

                      </form>

      
              
            
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
   
   $(document).ready(function () {

$("#requisition_form").submit(function (e) {

    //stop submitting the form to see the disabled button effect
    //e.preventDefault();

    //disable the submit button
    $("#btnSubmit").attr("disabled", true);

    

    return true;

});
});










$('#table').ready(function() {
    var table = $('<table></table>').addClass('foo');
        for (var i = 0; i < 10; i++) {
                row = $('<tr></tr>');
                for (var j = 0; j < 10; j++) {
                    var rowData = $('<td></td>').addClass('bar').text('result ' + j);
                    row.append(rowData);
                }
                table.append(row);
            }

        if ($('table').length) {
             $("#someContainer tr:first").after(row);
        }
        else {
            $('#someContainer').append(table);
        }
    });


$(document).ready(function () {
  $('.quantity, .actual_cost,#tax').change(function () {
    var parent = $(this).closest('tr');
    parent.find('.actual_total').val(parseFloat(parent.find('.quantity').val()) * parseFloat(parent.find('.actual_cost').val()))
   calculateSum();
  });
  
   
});


  function calculateSum() {
            var sum = 0;
            var grand = 0;
            var tax = 0;
            var include_tax = $("#tax").val();
            //iterate through each textboxes and add the values
            $(".actual_total").each(function () {
                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseFloat(this.value);
                    if(include_tax == 0){
                      tax = 0;
                    grand = tax + sum
                    }else{
                    tax = sum * .15;
                    grand = tax + sum
                    }
                }
            });

            //.toFixed() method will roundoff the final sum to 2 decimal places
            $("#subtotal").val('$' + parseFloat(sum, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $("#grandtotal").val('$' + parseFloat(grand, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $('#sales_tax').val('$' + parseFloat(tax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
             $("#contract_sum").val(grand.toFixed(2));
        }




  </script>



<script>
$('#actual_cost' ).on('input',function(){
let cost_variance;
var contractSum = $('#contract_sum').val();
var estimated_cost = parseFloat($('#estimated_cost').val());
cost_variance =parseFloat((estimated_cost-contractSum)/estimated_cost * 100);
console.log() ;
//console.log(cost_variance);
 $('#cost_variance').val((( estimated_cost-contractSum)/estimated_cost * 100  ? (estimated_cost-contractSum)/estimated_cost  *100 : 0).toFixed(2));
 var requisition_type = $('#requisition_type').val();
 console.log(requisition_type);
 if(cost_variance  > 15 || cost_variance  > 15 ){
 //alert('error cost variance is 15% above contract sum');
 }else{
 // alert('error cost variance is 15% below contract sum');
 }

});



$('#contract_sum').on('input',function(){
let cost_variance;
var contractSum = parseFloat($('#contract_sum').val());
var estimated_cost = parseFloat($('#estimated_cost').val());
//var requisition_type = $('#requisition_type').val());
if(contractSum >= 1500000){
 $('.above').show();
 console.log(requisition_type);
}else{
  $('.above').hide();
}

});
</script>
  
 
  <script>


$(document).ready(function(){
 $('#supplier').change(function() {
   supplier = $(this).val();
   $("#trn").empty();
$.ajax({
type:"GET",
url:"/getSuppliers",
dataType:'json', 
success: function (data) {  
              var len = 0;
              if(data != null){
              len= data.length;
           
              }
              if(len>0){
                for(var i =0; i< len;i++){
                 if(data[i].id == supplier){
                  var trn = data[i].trn;
                  var address = data[i].address;
                  $("#trn").val(trn);
                  $("#address").val(address);
                  
                 }
                }
              }
           }  

});
});
});


$(document).ready(function(){
  $('.btn-add-more').click(function(){

var html = $('.hide').html();
$('.img_div').after(html);
});


$("body").on("click",".btn-remove",function(){ 
$('.form-group').attr('disable',true);
      $(this).parents(".form-group").remove();
  });

});

      </script>






    @endpush