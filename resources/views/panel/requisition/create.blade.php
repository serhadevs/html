

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

.variance{
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
                        <h3 class="card-title">Create Purchase Requisition</h3>
                        </div>
                        </div>
                        </div>
                        
                        @if(count($errors)>0)
                        <div class="col-sm-10">
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/requisition" enctype="multipart/form-data">
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
                      


                 
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$requisition->user->abbrName()}}" readonly>
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
                        <input type="hidden" name='requisition_no' id="requisition_no" value="{{$requisition->requisition_no}}">
                        <input type="hidden" name='id' id="id" value="{{$requisition->id}}"> 
                      </div>
                    
                        <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{($requisition->created_at)->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                        </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                       
                          <input type="input" class="form-control"  value="{{$requisition->requisition_type->name}}"name='requisition_type' id="requisition_type" readonly>
                      
                      </div>
                        <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                        <div class="col-sm-4">
                           <select type="input" class="form-control" name="procurement_method" id="rocurement_method">
                          <option value="">Select method </option>
                      @foreach($methods as $method)
                      <option value="{{$method->id}}">{{$method->name}}</option>
                       @endforeach
                         </select>  
                       
                        </div>
                      </div>
                      
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Recommended </label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control"name ='supplier_id' id="supplier" >
                        <option value=''>Select supplier</option>
                         @foreach($suppliers as $supplier) 
                 
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        
                        @endforeach 
                        </select>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Delivery</label>
                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="delivery" id="delivery">
                          <option value=""  >Select specification </option>
                          <option value="cod">COD</option>
                           <option value="credit">Credit</option>
                           
                         </select>  
                       
                         
                        </div>
                        </div>



                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->institution->code}}" readonly name='cost_centre' >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                        <div class="col-sm-4">
                         
                        <input type="input" class="form-control" value="{{Request::old('commitment')}}" name='commitment' id='commitment'>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" value="{{Request::old('description')}}" name='description'></textarea>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-4">
                         
                        <select type="input" class="form-control"name ='category' id="category">
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
                              <input type="number" class="form-control" value="{{Request::old('contract_sum')}}" id="contract_sum" name='contract_sum'>
                          </div>
                          <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                          <div class="col-sm-4">
                           
                            <input type="number" class="form-control" value="{{$requisition->estimated_cost}}" readonly id= 'estimated_cost' name='estimated_cost' read>
                           
                          </div>
                          </div>

                          <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Date Required</label>
                            <div class="col-sm-4">
                              {{-- <input type="text" class="form-control"  name="cost_centre" id="cost_centre" placeholder="Enter cost-centre"> --}}
                           <div class="input-group date" id="date_require" data-target-input="nearest">
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
                            </div>
                        
                      <div class='variance'>

                        <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" value="{{Request::old('tcc')}}" name='tcc'>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">TRN</label>
                        <div class="col-sm-4">
                         
                         <input type="number" class="form-control" value="{{Request::old('trn')}}" id='trn' name='trn'>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                        <input type="text" class="form-control datepicker-input" name='tcc_expired_date' id='tcc_expired_date' value='{{Request::old('trn')}}' data-target="#tcc_expired"/>
                        <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        </div>
                        
                        </div>
                        
                        </div>


                      </div>

                      
                        

                      <div class="form-group row">
                        <label for="date-of-last" class="col-sm-2 col-form-label">Cost Variance</label>
                        <div class="col-sm-4">
                         
                         
                         <input type="number" class="form-control" value="" id='cost_variance' name='cost_variance' readonly>
                        </div>
                        
                        </div>
              
                        <div class="form-group row img_div ">
                        <div class="col-sm-4">
                       
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
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-10">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
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
   




// function myfunction(){
// $('#page').ready(function(){
 
// //   for(var i =0;products.length >i;i++)
// //   {
// //  // alert(products[i].value);
// //   //console.log(products[i].value)
// //   stocks.push(products[i].value);
// //   }
// var $div=$('#content');

// $("input[class=productname]").each(function() {
// productname.push($(this).val());
//  });

// $("input[class=quantity]").each(function() {
// quantity.push($(this).val());
//  });

// $("input[class=des]").each(function() {
// des.push($(this).val());
//  });

//  $("input[class=unitcost]").each(function() {
// unitcost.push($(this).val());
//  });








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


// function varianceCheck(){
// $('#variance').ready(function(){
//   var contractSum = parseFloat($('#contract_sum').val());
// var estimated_cost = parseFloat($('#estimated_cost').val());
// var cost_variance =parseFloat((estimated_cost-contractSum)/estimated_cost * 100);
//  if(cost_variance > 15)
//  var html = $('.variance').html();
//     $('.variance').after(html);

//     $('#cost_variance').val(((estimated_cost-contractSum)/estimated_cost * 100  ? (estimated_cost- contractSum)/estimated_cost  *100 : 0).toFixed(2));
//     console.log(cost_variance);
    
// });
// }

  </script>



<script>
$('#contract_sum,#estimated_cost' ).on('input',function(){
let cost_variance;
var contractSum = parseFloat($('#contract_sum').val());
var estimated_cost = parseFloat($('#estimated_cost').val());
cost_variance =parseFloat((estimated_cost-contractSum)/estimated_cost * 100);
console.log(cost_variance);
 $('#cost_variance').val(((estimated_cost-contractSum)/estimated_cost * 100  ? (estimated_cost- contractSum)/estimated_cost  *100 : 0).toFixed(2));
 if(cost_variance  > 15 ){
  $('.variance').show();
 }else{
  $('.variance').hide();
 }

});


</script>
  
 





    @endpush