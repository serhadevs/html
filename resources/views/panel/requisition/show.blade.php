

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
                        <h3 class="card-title">View Purchase Requisition</h3>
                        </div>
                        </div>
                        </div>
          
                </section>
            
                <div class="card-body">

                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}"  enctype="multipart/form-data" >
                  @csrf
                  @method('PATCH')  --}}
            
    
                        <div id="first">
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                            <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$requisition->requisition_no}}" readonly>
                                  </div>
        
                                  {{-- <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$internal_requisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                                </div> --}}
                                
                              </div>
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
                       
                        <input type="number" class="form-control" value="{{$requisition->internalrequisition->estimated_cost}}" readonly id= 'estimated_cost' name='estimated_cost' read>
                       
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
                        <label for="cost-centre" class="col-sm-2 col-form-label">Recommended Supplier </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->supplier->name}}"  disabled>
                        {{-- <select type="input" class="form-control"name ='supplier_id' id="supplier" required>
                        <option value='{{$requisition->supplier->id}}'>{{$requisition->supplier->name}}</option>
                         @foreach($suppliers->except($requisition->supplier->id) as $supplier)
                 
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        
                        @endforeach 
                        </select> --}}
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Term</label>
                        <div class="col-sm-4">
                          {{-- <select type="input" class="form-control" name="delivery" id="delivery" required>
                          <option value="{{$requisition->delivery}}"  >{{$requisition->delivery}} </option>
                          <option value="COD">COD</option>
                           <option value="Credit">Credit</option>
                           
                         </select>   --}}
                         <input type="input" class="form-control" value="{{$requisition->delivery}}"  disabled>
                       
                         
                        </div>
                        </div>

                        <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                          <div class="col-sm-4">
                              <textarea type="text" class="form-control" disabled name='description'>{{$requisition->description}}</textarea>
                          </div>
                          <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->category->name}}"  disabled>
                          {{-- <select type="input" class="form-control"name ='category' id="category">
                          <option value="{{$requisition->category_id}}" >{{$requisition->category->name}}</option>
                          
                          @foreach($categories as $category)
                          @if($requisition->category_id === $category->id)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                         @endforeach
                          </select> --}}
                           
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
                            <input type="number" class="form-control" value="{{$requisition->contract_sum}}" id="contract_sum" disabled  name='contract_sum'>
                            </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->procurement_method_id}}"  disabled>
                             {{-- <select type="input" class="form-control" name="procurement_method" id="rocurement_method">
                            {{-- <option value="">Select method </option> --}}
                        {{-- @foreach($methods as $method)
                        @if($requisition->procurement_method_id === $method->id)
                        <option value="{{$method->id}}">{{$method->name}}</option>
                        @else
                        <option value="{{$method->id}}">{{$method->name}}</option>
                        @endif
                         @endforeach
                           </select>   --}}
                        
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
                                    <input type="number" class="form-control" value="{{$requisition->pcc}}" name='ppc'>
                                </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='ppc_expired_date' id='ppc_expired_date' value='{{Request::old('trn')}}' data-target="#ppc_expired"/>
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
      
                              <label for="date-of-last"  class="col-sm-2 col-form-label">TRN</label>
                              <div class="col-sm-4">
                               
                               <input type="number" disabled class="form-control" value="{{$requisition->trn}}" id='trn' name='trn'>
                               
                              </div>
                              
                              </div>
                        
                        

                         

                         
                   
                        
                      

                        

                         

                        </div>
                           <div id="table" class="table-editable">
                <span class="table-add float-right mb-3 mr-2"></span>
          <table id="stock-table" class="table table-bordered table-responsive-md table-striped text-center">
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
          </table>
        </div>


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
        <div class="form-group row img_div ">
                        {{-- <div class="col-sm-6">
                       
                       <div class="form-group">
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
                      </div>  --}}
                     



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
                    {{-- <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" >Remove</button></td> --}}
                  </tr>
                    @endforeach
                  </tbody>
                </table>
              {{-- </form> --}}
              </div>
               </div> 
              <!-- /.card-body -->
            </div>
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
                       
                        <a type="button" href="/requisition"   class="btn btn-success float-left">back</a>
                        </div>
                        </div>
                        </div>

                        

                        </div>

                      

           

                   
                     
                        
                
                      
                  

                

                      

                        


                  </div>

                  </div>
                    
                  
                    
                
                  {{-- </form>   --}}
              
            
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
$('#progressText').html('Step -2')
});


$('#next-2').click(function(){
    $('#first').hide();
    $('#second').hide();
    $('#third').show();
    $('#progressBar').css("width","100%")
    $('#progressText').html('Step -3')

})

$('#previous').click(function(){
    $('#first').show();
    $('#second').hide();
    $('#progressBar').css("width","33.5%")
    $('#progressText').html('Step -1')

})
$('#previous-1').click(function(){
    $('#first').hide();
    $('#third').hide();
    $('#second').show();

    $('#progressBar').css("width","67%")
    $('#progressText').html('Step -2')

})

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
      $.get( {!! json_encode(url('/')) !!} + "/requisition/delete/"+id).then(function (data) {
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







    $('#contract_sum,#estimated_cost' ).on('input',function(){
let cost_variance;
var contractSum = parseFloat($('#contract_sum').val());
var estimated_cost = parseFloat($('#estimated_cost').val());
cost_variance =parseFloat((contractSum-estimated_cost)/estimated_cost * 100);
console.log(cost_variance);
 $('#cost_variance').val(((contractSum-estimated_cost)/estimated_cost * 100  ? (contractSum-estimated_cost)/estimated_cost  *100 : 0).toFixed(2));
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




  
 





    @endpush