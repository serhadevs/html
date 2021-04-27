

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
                            <input type="number" class="form-control" value="{{$ir->estimated_cost}}" name='estimated_cost' >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                        <div class="col-sm-4">
                         
                         <select type="input" class="form-control" name="budget_approve" id="budget_approve">
                          @if($ir->budget_approve === 'no')
                          <option selected value="{{ $ir->budget_approve }}" >No</option>
                          <option value="yes">Yes</option>
                          {{-- <option value="no">No</option> --}}
                          @endif
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
               @foreach($ir->stocks as $stock)
               <div class="form-group row">
              <tr>
                <td>
                  
                <input name='item_number[]' class='productname' id="item_number" value={{$stock->item_number}} type='text' size="5" style='border:none;outline:none;background: transparent;'>
               
                </td>
                <td>
                
                  {{-- <input name='quantity[]'  class='quantity' type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;'> --}}
                   <input name='description[]'  value={{$stock->description}} class='des' type='text' size="10" style='border:none;outline:none;background: transparent;'>
                </td>
                <td>
                <input name='quantity[]'  class='quantity'  value={{$stock->quantity}} type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;'>
                </td>
                {{-- <td>
                <input name='unit_cost[]'size="5" class='unitcost' type='number'style='width:80px; border:none;outline:none;background: transparent;'>
              
                </td> --}}
                <td>
                  <select name='unit[]' class='unit' id="unit" style='width:80px; border:none;outline:none;background: transparent;'>
                
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
                  <input name='unit_cost[]'size="5" class='unitcost' type='number'style='width:80px; border:none;outline:none;background: transparent;'>
                </td>
                <td>
                <input name='part_number[]' class='part_number' value="{{$stock->part_number}}" id="part_number"   type='text' size="5" style='border:none;outline:none;background: transparent;'>
                </td>
        

                <td>
                  <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                </td>
              </tr>
            </div>
            </tbody>
            @endforeach
          </table>
          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Comments/Justification</label>
              <textarea class="form-control" name="comments" rows="3" placeholder="{{$ir->comments}}"></textarea>
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
                        <button type="Submit" class="btn btn-danger float-right" >Submit</button>
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


$('#supplier').on('input',function(){
var supplier = parseFloat($('#supplier').val());
$('#supplier_input').val(supplier );

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




  </script>

  
 





    @endpush