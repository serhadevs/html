

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
                        <h3 class="card-title">View Internal Requisition Form</h3>
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

                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/internal_requisition/{{internal_requisition->id}}" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH') 
                   --}}
                      

                 
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                           
                          {{-- <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$internal_requisition->requisition_no}}" readonly>
                              </div>
    
                              {{-- <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control"  value="{{$internal_requisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                            </div> --}}
{{--                             
                          </div> --}}

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$internal_requisition->user->firstname[0]}}.{{$internal_requisition->user->lastname}}" readonly>
                          </div>

                          <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{$internal_requisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                        </div>
                        
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$internal_requisition->institution->name}}" readonly>
                          {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                          </div>
                          <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{$internal_requisition->department->name}}" readonly>
                        </div>
                        
                      </div>
                      


                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                        <div class="col-sm-4">
                        <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" class="form-control" value="{{$internal_requisition->estimated_cost}}" disabled name='estimated_cost' >
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                        <div class="col-sm-4">
                         
                         <select type="input" class="form-control" name="budget_approve" id="budget_approve" disabled>
                       
                          <option selected value="{{ $internal_requisition->budget_approve }}">{{$internal_requisition->budget_approve}} </option>
                          <option value="yes">yes</option>
                          <option value="no">no</option>
                          {{-- <option value="no">No</option> --}}
                      
                          {{-- @if($internal_requisition->budget_approve === 'no')
                          <option selected value="{{ $internal_requisition->budget_approve }}" >No</option>
                          @els
                         <option  value="yes" >Yes</option>
                         @endif --}}
 
                         </select>  
                         
                        </div>
                        </div>

                        
                        
                        <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                        <div class="col-sm-4">
                            <input type="tele" class="form-control" value="{{$internal_requisition->phone}}" disabled name='phone'>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                        <div class="col-sm-4">
                         
                         <input type="email" class="form-control" value="{{$internal_requisition->email}}" disabled id='email' name='email'>
                         
                        </div>
                        </div>

                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Procurement type</label>
                       
                        <div class="col-sm-4">
                   
                            <input type="text" class="form-control" value="{{$internal_requisition->requisition_type->name}}" id='requisition_type' name='requisition_type' disabled>
                          
                        
                        </div> 
                        <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{$internal_requisition->priority}}" id='priority' name='priority' disabled> 
                        </div>
                        </div>
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">General Description </label>
                        <div class="col-sm-4">
                            <textarea type="text" class="form-control" readonly  name='description' required>{{$internal_requisition->description}}</textarea>
                        </div>
                        <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                            <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$internal_requisition->requisition_no}}" readonly>
                       
                       
                        </div>          
                      </div>

          

          <div id="table" class="">
              
          <table id="stock-table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Total</th>
     
                
              </tr>
            </thead>
            <tbody>
               @foreach($internal_requisition->stocks as $stock)
             
              <tr>
                <td>
                  
                {{$stock->item_number}}
               
                </td>
                <td>
                
                  {{-- <input name='quantity[]'  class='quantity' type='number' size="5"style='width:80px;border:none;outline:none;background: transparent;'> --}}
                  {{$stock->description}} 
                </td>
                <td>
               {{$stock->quantity}}
                </td>
                {{-- <td>
                <input name='unit_cost[]'size="5" class='unitcost' type='number'style='width:80px; border:none;outline:none;background: transparent;'>
              
                </td> --}}
                <td>         
                  
                 {{$stock->unit_of_measurement->name}}
               
                 
                
                
                </td> 
                <td>
                  {{$stock->unit_cost}}
                </td>
                <td>
                {{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2) }}
                </td>
              </tr>

            </tbody>
            @endforeach
          </table>
             {{-- table div end --}}
            </div> 


            @if($internal_requisition->stocks[0]->estimated_total != null)
             <div class="row">
      <div class="col-sm-8">
             
      </div>

                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  size="5">Sub Total</td>
    <td><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{$internal_requisition->stocks->sum('estimated_total')}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td size="5">Sales Tax (15.0%)</td>
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internal_requisition->stocks->sum('estimated_total') * .15) }}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{$internal_requisition->estimated_cost}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
      @endif



      <div class="row">
      <div class="col-sm-8">
             
      </div>

                        
                  
            
            
      </div>

          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Comments/Justification</label>
              <textarea class="form-control" name="comments" rows="3" disabled>{{$internal_requisition->comments}}</textarea>
              </div>
            </div>
            @if($internal_requisition->comment->isNotEmpty())
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Refusal Comments</label>
              <textarea class="form-control" rows="3" disabled   >
            @foreach($internal_requisition->comment as $comment)
            {{$comment->user->abbrName()}}  : {{$comment->comment}}
            @endforeach
              </textarea>
              </div>
            </div>
            @endif
            


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
                    @foreach($internal_requisition->attached as $file)
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
              
 





                        {{-- column length end --}}
                        </div>
                        </div>

                     
                         </div>

  <div class="form-group row">
  <div class="col-sm-6">
</br>
  @if(isset($internal_requisition->certified_internal_requisition))
    @if($internal_requisition->certified_internal_requisition->is_granted ===1)
    Certify IRF by: <span class='badge badge-success'>{{$internal_requisition->certified_internal_requisition->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$internal_requisition->certified_internal_requisition->created_at}}</span></br>
    @endif
    @endif

    @if(isset($internal_requisition->approve_internal_requisition))
    @if($internal_requisition->approve_internal_requisition->is_granted ===1)
    Approve IRF by: <span class='badge badge-success'>{{$internal_requisition->approve_internal_requisition->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$internal_requisition->approve_internal_requisition->created_at}}</span></br>
    @endif
    @endif
     

 @if($internal_requisition->budget_commitment)
     Budget Commitment by: <span class='badge badge-success'>{{$internal_requisition->budget_commitment->user->abbrName()}} </span></br>
      Date:  <span class='badge badge-success'>{{$internal_requisition->budget_commitment->created_at}}</span></br>
      @endif

  @if(isset($internal_requisition->approve_budget))
  @if($internal_requisition->approve_budget->is_granted===1)
                        Budget Approve by: <span class='badge badge-success'>{{$internal_requisition->approve_budget->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internal_requisition->approve_budget->created_at}}</span></br>
                          @endif
                         @endif
      
  
     
  </div>
 


  
  <div class="col-sm-6">
    

@if(isset($internal_requisition->requisition->check))
@if(($internal_requisition->requisition->check->is_checked===1))
    Accepted by: <span class='badge badge-success'>{{$internal_requisition->requisition->check->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$internal_requisition->requisition->check->created_at}}</span></br>
     @endif
     @endif
     
    @if(isset($internal_requisition->requisition->approve))
    @if($internal_requisition->requisition->approve->is_granted===1)
    Approve Requisition by:  <span class='badge badge-success'>{{$internal_requisition->requisition->approve->user->abbrName()}}</span></br>
    Date:<span class='badge badge-success'>{{$internal_requisition->requisition->approve->created_at}}</span></br>
    @endif 
    @endif 

    @if(isset($internal_requisition->requisition->purchaseOrder))
    Prepared PO by: :<span class='badge badge-success'>  <b>{{$internal_requisition->requisition->purchaseOrder->user->abbrName()}}</span></b> </br>
    Date:<span class='badge badge-success'>  <b>{{$internal_requisition->requisition->purchaseOrder->created_at}}</span></b></br>
    @endif
   
    
    

    

  </div>

  </div> 
  </div>
  </div>

                        <div class="row">
                        <div class="col-10">
                        <a type="button"  href="/internal_requisition" class="btn btn-outline-success">Back</a>
                        
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