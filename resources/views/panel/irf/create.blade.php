

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

.hide{
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
                        <h3 class="card-title">Create Internal Requisition Form</h3>
                        </div>
                        </div>
                        </div>
                        
                        @if(count($errors)>0)
                        <div class="col-sm-10">
                  <div class="alert alert-danger">
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

                <form class="form-horizontal" id="internal_request_form" method="Post" autocomplete="off" action="/internal_requisition" enctype="multipart/form-data">
                  @csrf
                  
                      

                 
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{auth()->user()->abbrName()}}" readonly>
                          </div>

                          <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{now()->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                        
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{auth()->user()->institution->name}}" readonly>
                          {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                          </div>
                          <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{auth()->user()->department->name}}" readonly>
                        </div>
                        
                      </div>
                      


                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" value="{{Request::old('estimated_cost')}}" name='estimated_cost'required >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Budget Activity</label>
                        <div class="col-sm-4">
                         
                         <select type="input" class="form-control" name="budget_approve" id="budget_approve" required>
                          <option value="">Select method </option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                         </select>  
                         
                        </div>
                        </div>

                        
                        
                        <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                        <div class="col-sm-4">
                            <input type="tele" class="form-control" value="{{Request::old('phone')}}" name='phone'required>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                        <div class="col-sm-4">
                         
                         <input type="email" class="form-control" value="{{Request::old('email')}}" id='email' name='email'required>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Procurement type</label>
                       
                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="requisition_type" id="requisition_type" required>
                            <option value="">Select type </option>
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                         @endforeach
                           </select>  
                         </select>  
                        
                        </div> 
                        <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                         <select type="input" class="form-control" name="priority" id="priority" required>
                          <option value="">Select priority</option>
                          <option value="very high">Very High</option>
                          <option value="high">High</option>
                          <option value="medium">Medium</option>
                          <option value="low">Low</option>
                         </select>  
                        
                         
                        </div>
                        </div>
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">General Description </label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" value="{{Request::old('general_description')}}" name='general_description' required></textarea>
                        </div>
                       
                       
                        </div>

          

                              <div id="table" class="table-editable">
                <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success">
            
            <i class="fas fa-plus fa-2x" id = 'add' aria-hidden="true"></i></a></span>
          <table id="stock-table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                 <th class="text-center">Unit Cost</th>
                <th class="text-center">Part Number</th>
                 <th class="text-center">Option</th>
                
              </tr>
            </thead>
            <tbody>
               <div class="form-group row">
              <tr>
                <td>
                  
                <input name='item_number[]' class='productname' id="item_number" type='text' size="5" style='border:none;outline:none;background: transparent;'>
               
                </td>
                <td>
                
                  
                   <input name='description[]' class='des' type='text' size="10" style='border:none;outline:none;background: transparent;' required>
                </td>
                <td>
                <input name='quantity[]'  class='quantity' type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;' required>
                </td>
                
                <td>
                  <select name='unit[]' class='unit' id="unit" style='width:80px; border:none;outline:none;background: transparent;'required>
                  <option value="">select</option>
                  @foreach ($units as $unit)
                  <option name='unit[]' value="{{$unit->id}}">{{$unit->name}}</option>
                  @endforeach
                  </select>
                  </select>
                </td> 
                <td>
                  <input name='unit_cost[]'size="5" class='unitcost' min="0.00" step="0.01"  type='number'style='width:80px; border:none;outline:none;background: transparent;' required>
                </td>
                <td>
                  <input name='part_number[]' class='part_number' id="part_number" type='text' size="5" style='border:none;outline:none;background: transparent;'>
                </td>
        

                <td>
                  <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                </td>
              </tr>
            </div>
            </tbody>
          </table>

          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Comments/Justification</label>
                <textarea class="form-control" name="comments" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>

                         
                        <div class="col-sm-6">
                       <div class="form-group row img_div ">
                     
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

                   <div class ='hide'>
                      <div class="form-group row">
                      {{-- <div class="col-sm-6"> --}}
  
                      <div class="input-group">
                      <div class="custom-file">
                      <input type="file" name="file_upload[]" class="form-control" id="file_upload">

                      </div>
                      <div class="input-group-append">
                      <button class="btn btn-default btn-remove" type="button"><i class="glyphicon glyphicon-plus"></i>Remove</button>
                      </div>
                      </div>
                      {{-- </div> --}}
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
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="Submit" id ="btnSubmit" class="btn btn-block btn-outline-primary " >Submit</button>
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

$("#internal_request_form").submit(function (e) {

    //stop submitting the form to see the disabled button effect
    //e.preventDefault();

    //disable the submit button
    $("#btnSubmit").attr("disabled", true);

    

    return true;

});
});


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


// $('#supplier').on('input',function(){
// var supplier = parseFloat($('#supplier').val());
// $('#supplier_input').val(supplier );

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




  </script>



<script>
$('#contract_sum,#estimated_cost' ).on('input',function(){
let cost_variance;
var contractSum = parseFloat($('#contract_sum').val());
var estimated_cost = parseFloat($('#estimated_cost').val());
cost_variance =parseFloat((estimated_cost-contractSum)/estimated_cost * 100);
console.log(cost_variance);
 $('#cost_variance').val(((estimated_cost-contractSum)/estimated_cost * 100  ? (estimated_cost- contractSum)/estimated_cost  *100 : 0).toFixed(2));

});


</script>
  
 





    @endpush