

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
                        <h3 class="card-title">Edit Internal Requisition Form</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/internal_requisition/{{$ir->id}}" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH') 
                  
                      

                 
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">
                           
  

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$ir->user->firstname[0]}}.{{$ir->user->lastname}}" readonly>
                          </div>

                          <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{$ir->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                        
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$ir->institution->name}}" readonly>
                          {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                          </div>
                          <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{$ir->department->name}}" readonly>
                        </div>
                        
                      </div>
                      


                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                        <div class="col-sm-4">
                        <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" readonly class="form-control" min="0.00" step="0.01"  id="estimated_cost" value="{{$ir->estimated_cost}}" name='estimated_cost' >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                        <div class="col-sm-4">
                         
                         <select type="input" class="form-control" name="budget_approve" id="budget_approve">
                       
                          <option selected value="{{ $ir->budget_approve }}">{{$ir->budget_approve}} </option>
                          <option value="yes">yes</option>
                          <option value="no">no</option>
                          {{-- <option value="no">No</option> --}}
                      
                          {{-- @if($ir->budget_approve === 'no')
                          <option selected value="{{ $ir->budget_approve }}" >No</option>
                          @els
                         <option  value="yes" >Yes</option>
                         @endif --}}
 
                         </select>  
                         
                        </div>
                        </div>

                        
                        
                        <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                        <div class="col-sm-4">
                            <input type="tele" class="form-control" value="{{$ir->phone}}" name='phone'>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                        <div class="col-sm-4">
                         
                         <input type="email" class="form-control" value="{{$ir->email}}" id='email' name='email'>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Procurement type</label>
                       
                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="requisition_type" id="requisition_type">
                           
                        @foreach($types as $type)
                        @if($ir->type === $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @else
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                         @endforeach
                           </select>  
                          
                        
                        </div> 
                        <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                         <select type="input" class="form-control" name="priority" id="priority">
                         <option value="{{$ir->priority}}">{{$ir->priority}}</option>
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
                            <textarea type="text" class="form-control" value="" name='general_description' required>{{$ir->description}}</textarea>
                        </div>
                        <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$ir->requisition_no}}" readonly>
                       
                       
                        </div>
                        </div>

          
                        <div class="form-group row">
                          <div class="col-sm-12">
                <div id="table" class="table-editable">
                  
                <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success">
            
            <i class="fas fa-plus fa-2x" id = 'add' aria-hidden="true"></i></a></span>
           
          <table id="stock-table" style="width:100%;" class=" table-bordered text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Total</th>
                <th class="text-center">Option</th>
                
              </tr>
            </thead>
            <tbody>
               @foreach($ir->stocks as $stock)
           
              <tr>
                <td>
                  
                <input name='item_number[]' class='productname' id="item_number" value={{$stock->item_number}} type='text' size="5" style='border:none;outline:none;background: transparent;'>
               
                </td>
                <td>
                   <textarea  name='description[]' class='des' size="40" style='border:none;outline:none;background: transparent;' required>{{$stock->description}} </textarea>
                </td>
                <td>
                <input name='quantity[]'  class='quantity'  value={{$stock->quantity}} type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;' required>
                </td>
               
                <td>
                  <select name='unit[]' class='unit' id="unit" style='width:80px; border:none;outline:none;background: transparent;' required>
                
                  @foreach ($units as $unit)
                  @if($stock->unit_of_measurement_id == $unit->id)
                  <option selected value="{{ $stock->unit_of_measurement_id }}" >{{ $stock->unit_of_measurement->name }}</option>
                  @else
                  <option name='unit[]' value="{{$unit->id}}">{{$unit->name}}</option>
                  @endif
                  @endforeach
                  </select>
                
                </td> 
                <td>
                
                  <input name='unit_cost[]'size="5" class='unitcost' min="0.00" step="1"  value="{{number_format($stock->unit_cost,2)}}" type='number'style='width:80px; border:none;outline:none;background: transparent;' required>
                </td>
                <td>
                <input name='estimated_total[]' class='estimated_total' value="{{number_format($stock->estimated_total,2)}}" id="estimated_total"   type='text' size="5" style='border:none;outline:none;background: transparent;' readonly>
                </td>
        

                <td>
                  <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                </td>
              </tr>
         
            </tbody>
            @endforeach
          
          </table>
        </div>
      </div>
    </div>

     <div class="row">
      <div class="col-sm-8">
             
      </div>

                         
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  size="5">Sub Total</td>
    <td><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{number_format($ir->stocks->sum('estimated_total'),2)}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td size="5">Sales Tax (15.0%)</td>
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format(($ir->stocks->sum('estimated_total') * .15),2)}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{number_format($ir->estimated_cost,2)}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Comments/Justification</label>
              <textarea class="form-control" rows="3"  name='comments' >
              {{$ir->comments}}
              </textarea>
              </div>
            </div>
            {{-- {{$ir->comment}} --}}
            @if($ir->comment->isNotEmpty())
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Refusal Comments</label>
<textarea class="form-control" rows="3" disabled>
                  @foreach($ir->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}}
                  @endforeach
</textarea>
              </div>
            </div>
            @endif
          </div>
          <div class="row">
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
      @foreach($ir->attached as $file)
      <tr> 
      <td>
      <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
      </td> 
    <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
      <td> <button class="btn btn-danger" onclick="deleteAttached({{$file->id}})" type="button" >Remove</button></td>
    </tr>
      @endforeach
    </tbody>
  </table>
{{-- </form> --}}
</div>
 </div> 

 <div class="col-sm-6">
                       
  <div class="form-group img_div">
  <label for="exampleInputFile">Support Documents</label>
  <div class="input-group">
  <div class="custom-file">
 <input type="file" name="file_upload[]" class="form-control" id="file_upload" accept="docs/*">
 </div>
 <div class="input-group-append">
 <button class="btn btn-default btn-add-more" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
 </div>
 </div>

 <div class ='hide'>
  <div class="form-group">
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
                        <button type="Submit" class="btn btn-block btn-outline-primary btn-lg" >Update</button>
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
    {{-- <script src="/js/dataTables.select.min.js"></script> --}}
    <script src="/js/editable-table.js"></script> 
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




$('#estimated_cost').on('change',function(){
  var approve_budget = {!! json_encode($ir->approve_budget) !!};
  var $input = $('input#estimated_cost');
  if(approve_budget != null){
    swal(
  'Warning',
  'Changing estimated cost will result in reseting this application.',
  'warning'
        )
    approve_budget = null;
  
  }
    });

    // $('#add').on('click',function(){
    // $('.hidden').removeAttr("disabled");
    // });



function deleteAttached(id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/attached/delete/"+id).then(function (data) {
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


$(document).ready(function () {
  $('.quantity, .unitcost').change(function () {
    var parent = $(this).closest('tr');
    parent.find('.estimated_total').val(parseFloat(parent.find('.quantity').val()) * parseFloat(parent.find('.unitcost').val()))
   calculateSum();
  });
  
   
});


  function calculateSum() {
            var sum = 0;
            var grand = 0;
            var tax = 0;
            //iterate through each textboxes and add the values
            $(".estimated_total").each(function () {
                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseFloat(this.value);
                    tax = sum * .15;
                    grand = tax + sum
                }
            });

            //.toFixed() method will roundoff the final sum to 2 decimal places
            $("#subtotal").val('$' + parseFloat(sum, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $("#grandtotal").val('$' + parseFloat(grand, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            $('#sales_tax').val('$' + parseFloat(tax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
             $("#estimated_cost").val(grand.toFixed(2));
        }


  </script>

  
 





    @endpush