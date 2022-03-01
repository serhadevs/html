

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

    @section('content')
    <style type="text/css">
/* #second {
display:none;
}

#third{
  display:none;
} */
.title{
text-align: center;
}

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
        
              <div class="col-sm-10">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Edit Requisition</h3>
                        </div>
                        </div>
                        </div>
          
                </section>
            
                <div class="card-body">

                <form class="form-horizontal" method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}"  enctype="multipart/form-data" >
                  @csrf
                  @method('PATCH') 
            
    
                        <div id="first">
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                           
                             <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$requisition->internalrequisition->user->abbrName()}}" readonly>
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{$requisition->department->name}}" readonly>
                        </div>
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$requisition->institution->name}}" readonly>
                          {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{$requisition->internalrequisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                       
                          <input type="input" class="form-control"  value="{{$requisition->internalrequisition->requisition_type->name}}"name='date_ordered' id="date-ordered" readonly>
                      
                      </div>
                      <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                      <div class="col-sm-4">
                         <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                        <input type="number" class="form-control" required placeholder="{{number_format($requisition->internalrequisition->estimated_cost,2)}}" readonly id= 'estimated_cost' name='estimated_cost' read>
                       
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->cost_centre}}" name='cost_centre' disabled>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                        <div class="col-sm-4">
                         
                         <input type="input" class="form-control" value="{{$requisition->commitment_no}}" name='commitment' disabled>
                         
                        </div>
                        </div>
                          <div class="form-group row">
                              <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$requisition->requisition_no}}" readonly>
                                </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Terms</label>
                        <div class="col-sm-4">
                           <select type="input" class="form-control" name="delivery" id="delivery" required>
                          <option value="{{$requisition->delivery}}"  >{{strtoupper($requisition->delivery)}} </option>
                          <option value="COD">COD</option>
                           <option value="Credit">Credit</option>
                           
                         </select>  
                       
                         
                        </div>
                              
                            </div>
                      
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Recommended Supplier </label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control"name ='supplier_id' id="supplier" required>
                        <option value='{{$requisition->supplier->id}}'>{{$requisition->supplier->name}}</option>
                         @foreach($suppliers->except($requisition->supplier->id) as $supplier)
                 
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        
                        @endforeach 
                        </select>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Address</label>
                        <div class="col-sm-4">
                         
                        <input type="text" class="form-control" value="{{$requisition->supplier->address}}" id='address' name='address' readonly>
                         
                        </div>
                        </div>

                        <div class="form-group row">
                          <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                         
                          <div class="col-sm-4">
                            <select type="input" class="form-control" name="currency_type" id="currency_type" readonly required>
                              <option  selected value="{{$requisition->internalrequisition->currency->id}}">{{$requisition->internalrequisition->currency->abbr}} </option>
                          {{-- @foreach($currencies as $currency)
                          <option value="{{$currency->id}}">{{$currency->abbr}}</option>
                           @endforeach --}}
                             </select>  
                           </select> 
                          
                          </div> 
                          <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                          <div class="col-sm-4">
                           <select type="input" class="form-control" name="tax" id="tax" required>
                            <option selected value={{$requisition->tax_confirmed}}>{{$requisition->tax_confirmed ===1 ? "Yes":"No" }}</option>
                            @if($requisition->tax_confirmed !=1)
                            <option value=1>Yes</option>
                            @else
                            <option value=0>No</option>
                            @endif
                           
                           </select>  
                          
                           
                          </div>
                          </div>

                        <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                          <div class="col-sm-4">
                              <textarea type="text" class="form-control" value="" name='description'>{{$requisition->description}}</textarea>
                          </div>
                          <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                          <div class="col-sm-4">
                           
                          <select type="input" class="form-control"name ='category' id="category">
                          <option value="{{$requisition->category_id}}" >{{$requisition->category->name}}</option>
                          
                          @foreach($categories as $category)
                          @if($requisition->category_id === $category->id)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                         @endforeach
                          </select>
                           
                          </div>
                          </div>

                              
                        {{-- @foreach($types as $type)
                        @if($ir->type === $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @else
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                         @endforeach
                           </select>  
                           --}}

                          <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                            <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" class="form-control" value="{{$requisition->contract_sum}}" id="contract_sum" name='contract_sum' readonly required>
                            </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                          <div class="col-sm-4">
                             <select type="input" class="form-control" name="procurement_method" id="rocurement_method"required>
                        <option value="{{$requisition->procurement_method->id}}">{{$requisition->procurement_method->name}}</option>
                        @foreach($methods->except([$requisition->procurement_method->id]) as $method)
                        <option value="{{$method->id}}">{{$method->name}}</option>
                         @endforeach
                           </select>  
                        
                          </div>
                            </div>

                            <div class='above'>

                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value="{{$requisition->tcc}}" name='tcc'>
                              </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='tcc_expired_date' id='tcc_expired_date' value='{{$requisition->tcc_expired_date}}' data-target="#tcc_expired"/>
                              <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              </div>
                              
                              </div>
                              
                              </div>
      
                               <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$requisition->ppc}}" name='ppc'>
                                </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='ppc_expired_date' id='ppc_expired_date' value='{{$requisition->ppc_expired_date}}' data-target="#ppc_expired"/>
                              <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              </div>
                              
                              </div>
                              
                              </div>
      
                              
      
      
                             </div>
      
                            <div class="form-group row">
                              <label for="date-of-last" class="col-sm-2 col-form-label">Percentage Variance</label>
                              <div class="col-sm-4">
                               
                               
                              <input type="number" class="form-control" value="{{$requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                              </div>
      
                              <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Trn</label>
                              <div class="col-sm-4">
                               
                               <input type="number" class="form-control" value="{{$requisition->supplier->trn}}" id='trn' name='trn'readonly>
                               
                              </div>
                              
                              </div>
                        
                        

                         

                         
                   
                        
                      

                        

                         

                        </div>
                           <div id="table" class="table-editable">
                <span class="table-add float-right mb-3 mr-2"></span>
          <table id="stock-table" class="table table-bordered table-responsive-md text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                {{-- <th class="text-center">Unit Cost</th>
                <th class="text-center">Total</th> --}}
                <th class="text-center">Actual Unit Cost</th>
                <th class="text-center">Total</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($requisition->internalrequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                  <td><input name='quantity[]'  class='quantity' type='number' value="{{$stock->quantity}}" size="5"style='width:60px;border:none;outline:none;background: transparent;' readonly required></td>
                <td>{{$stock->unit_of_measurement->name}}</td>
                {{-- <td>{{$stock->unit_cost}}</td> --}}
                {{-- <td>{{$stock->estimated_total}}</td> --}}
                 <td>
                  <input name='actual_cost[]' id="actual_cost" size="5" value="{{$stock->actual_cost }}" class='actual_cost' min="0.00" step="1"  type='number'style='width:80px; border:blue;outline:blue;background:white;' required></td>
                <td>
                  <input name='actual_total[]' id="actual_total" size="5" value="{{$stock->actual_total}}" class='actual_total' min="0.00" step="1"  type='number'style='width:80px; border:blue;outline:none;background: transparent;' readonly required>
                </td>
            
       
              
              </tr>
               
           @endforeach
         
  
            </tbody>
          </table>
        </div>
          <div class="row">
      <div class="col-sm-8">
             
      </div>

                         
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  style='width:1px;'>Sub Total</td>
    <td style='width:20px;'><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total'),2) }}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td style='width:20px;'>Sales Tax (15.0%)</td>
    @if($requisition->tax_confirmed ===0)
     <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * 0,2) }}" style='border:none;outline:none;background: transparent;'></td>
    @else
    <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * .15,2) }}" style='border:none;outline:none;background: transparent;'></td>
    @endif
    </tr>
   <tr>
    <td  style='width:20px;'>Grand Total</td>
     <td style='width:20px;'><input id='grandtotal' readonly type='text' value="${{number_format($requisition->contract_sum,2)}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
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



          @if($requisition->internalrequisition->comment->isNotEmpty())
          <div class="col-sm-6">
            <!-- textarea -->
            <div class="form-group">
              <label>Refusal Comments</label>
<textarea class="form-control" rows="3" disabled>
@foreach($requisition->internalrequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}}
@endforeach
</textarea>
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
                        
                 
                       

                      <div class="col-sm-6">
                            <label for="exampleInputFile">Attached Files</label>
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
                    @foreach($requisition->files as $file)
                    <tr> 
                    <td>
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                    <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" >Remove</button></td>
                  </tr>
                    @endforeach
                  </tbody>
                   <tbody>
                    @foreach($requisition->internalrequisition->attached as $file)
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
              <!-- /.card-body -->
              {{-- <div class="form-group">
                        {{ asset('storage/'.$application->photo_upload) }}
                       <label for="exampleInputFile">Attached files</label>
                       <div class="input-group">
                       <div class="custom-file">
                         @foreach($requisition->files as $file)
                      {{-- <input type="text" name="file_upload[]" class="form-control" id="file_upload" accept="docs/*"> --}}
                          {{-- {{$file->filename}}
                     
                      
                      </div>
                      <div class="input-group-append">
                         <button class="btn btn-default " type="button"><i class="glyphicon glyphicon-plus"></i>View</button>
                      <button class="btn btn-default " type="button"><i class="glyphicon glyphicon-plus"></i>Remove</button>
                      </div>
                       @endforeach
                      </div>
                      </div> --}} 
                   
                      </div> 





                      </div> 

                     



                        </div>
                        <div class="row">
                        <div class="col-10">
                           
                       
                        <a type="button" href="/requisition"   class="btn btn-outline-success float-left btn-lg">Back</a>
                        <button type="Submit"   class="btn btn-outline-primary float-right btn-lg">Submit</button>
                        </div>
                      
                       
                        
                        </div>
                        </div>
                        </div>

                        

                        </div>

                      

           

                   
                     
                        
                
                      
                  

                

                      

                        


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
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script src="/js/sweet/sweetalert.min.js"></script> 
    @endpush
      
    @push('scripts')
    <script>
//     $(document).ready(function(){
// $('#next-1').click(function(){
// $('#second').show();
// $('#first').hide();
// $('#third').hide();
// $('#progressBar').css("width","67%")
// $('#progressText').html('Step -2')
// });


// $('#next-2').click(function(){
//     $('#first').hide();
//     $('#second').hide();
//     $('#third').show();
//     $('#progressBar').css("width","100%")
//     $('#progressText').html('Step -3')

// })

// $('#previous').click(function(){
//     $('#first').show();
//     $('#second').hide();
//     $('#progressBar').css("width","33.5%")
//     $('#progressText').html('Step -1')

// })
// $('#previous-1').click(function(){
//     $('#first').hide();
//     $('#third').hide();
//     $('#second').show();

//     $('#progressBar').css("width","67%")
//     $('#progressText').html('Step -2')

// })

// });




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



function deleteFile(id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/file/delete/"+id).then(function (data) {
        console.log(data);
        if (data == "success") {
          swal(
            "Done!",
            "The File was successfully deleted!",
            "success").then(esc => {
              if(esc){
               location.reload();
              }
            });
          }
          else if(data=="existing_sign_off"){
            swal("Error",
            "This requisition is already signed off and is not allowed to be deleted.",
            "error");
          }
          else{
            swal(
              "Oops! Something went wrong.",
              "The file was NOT deleted.",
              "error");
            }
          });
        }
      });
    }







//     $('#contract_sum,#estimated_cost' ).on('input',function(){
// let cost_variance;
// var contractSum = parseFloat($('#contract_sum').val());
// var estimated_cost = parseFloat($('#estimated_cost').val());
// cost_variance =parseFloat((estimated_cost-contractSum)/estimated_cost * 100);
// console.log(cost_variance);
//  $('#cost_variance').val(((estimated_cost-contractSum)/estimated_cost * 100  ? (estimated_cost-contractSum)/estimated_cost  *100 : 0).toFixed(2));
//  var requisition_type = $('#requisition_type').val();
//  console.log(requisition_type);
//  if(cost_variance  > 15 || cost_variance  > 15 ){
//  //alert('error cost variance is 15% above contract sum');
//  }else{
//  // alert('error cost variance is 15% below contract sum');
//  }

// });


$(document).ready(function(){
$('#contract_sum').on('input',function(){
let cost_variance;
var contractSum = parseFloat($('#contract_sum').val());
var estimated_cost = parseFloat($('#estimated_cost').val());
//var requisition_type = $('#requisition_type').val());
if(contractSum >= 1500000){
 $('.above').show();

}else{
  $('.above').hide();
}

})
var contractSum = parseFloat($('#contract_sum').val());
if(contractSum >= 1500000){
 $('.above').show();

}else{
  $('.above').hide();
}




});



$(document).ready(function () {
  $('.quantity, .actual_cost,#tax').change(function () {
    var parent = $(this).closest('tr');
    parent.find('.actual_total').val(parseFloat(parent.find('.quantity').val()) * parseFloat(parent.find('.actual_cost').val()))
   calculateSum();
   percentageVariance();
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


        function percentageVariance()
      {
        var contractSum = parseFloat($('#contract_sum').val());
        var estimated_cost = {!! json_encode($requisition->internalrequisition->estimated_cost, JSON_HEX_TAG) !!};
        console.log(estimated_cost);
        $('#cost_variance').val((( estimated_cost-contractSum)/estimated_cost * 100).toFixed(2));
      }




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

      </script>


  
 





    @endpush