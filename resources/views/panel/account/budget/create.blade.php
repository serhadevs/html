

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
                        <h3 class="card-title">Create Commitment Budget</h3>
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
              </div>
            
                <div class="card-body">

                <form class="form-horizontal" method="Post" id='budget_commitment_form' autocomplete="off" action="/budgetcommitment" enctype="multipart/form-data">
                  @csrf
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">


                            <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->user->firstname[0]}}.{{$internalrequisition->user->lastname}}" readonly>
                                <input type="hidden" class="form-control"  value="{{$internalrequisition->id}}"name='id' id="id" readonly> 
                                </div>
        
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$internalrequisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                                </div>
                                
                              </div>
                                  <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->institution->name}}" readonly>
                                  {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                                  </div>
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control" value="{{$internalrequisition->department->name}}" readonly>
                                </div>
                                
                              </div>
                              
        
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" placeholder="${{number_format($internalrequisition->estimated_cost,2)}}" name='estimated_cost' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->budget_approve}}" readonly>
                                </div>
                                </div>
        
                                
                                
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                                <div class="col-sm-4">
                                    <input type="tele" class="form-control" value="{{$internalrequisition->phone}}" name='phone' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                                <div class="col-sm-4">
                                 
                                 <input type="email" class="form-control" value="{{$internalrequisition->email}}" id='email' name='email' readonly>
                                 
                                </div>
                                </div>
        
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Procurement</label>
                                <div class="col-sm-4">
                                    <input type="input" class="form-control" value="{{$internalrequisition->requisition_type->name}}" readonly>
                                
                                </div> 
                                <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->priority}}" readonly>
                                 
                                </div>
                                </div>
                                <div class="form-group row">
                                  <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                                 
                                  <div class="col-sm-4">
                                    <select type="input" class="form-control" name="currency_type" id="currency_type" readonly required>
                                    
                                  <option selected value="{{$internalrequisition->currency->id}}">{{$internalrequisition->currency->abbr}}</option>
                                     </select>  
                                   </select>  
                                  
                                  </div> 
                                  <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                                  <div class="col-sm-4">
                                   <select type="input" class="form-control" name="tax" id="tax" readonly required>
                                    <option selected value="{{$internalrequisition->tax_confirmed}}">{{$internalrequisition->tax_confirmed === 1 ? "Yes" : "no"}}</option>
        
                                   </select>  
                                  
                                   
                                  </div>
                                  </div>
                                <div class="form-group row">
                                  <label for="cost-centre" class="col-sm-2 col-form-label">Requisition no.</label>
                                  <div class="col-sm-4">
                                      <input type="input" class="form-control" value="{{$internalrequisition->requisition_no}}" readonly>
                                  
                                  </div> 
                                    <label  for="cost-centre" class="col-sm-2 col-form-label">General Description</label>
                                  <div class="col-sm-4">
                                   <textarea  readonly class="form-control" name="comments" rows="3">{{$internalrequisition->description}}</textarea>
                                   
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
                                  <th class="text-center">Total</th>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($internalrequisition->stocks as $stock)
                                <tr>
                                
                                  <td>{{$stock->item_number}}</td>
                                  <td>{{$stock->description}}</td>
                                  <td>{{$stock->quantity}}</td>
                                  <td>{{$stock->unit_of_measurement->name}}</td>
                                  <td>${{number_format($stock->unit_cost,2)}}</td>
                                  <td>{{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2)}}</td>
                              
                         
                                
                                </tr>
                                 
                             @endforeach
                           
                    
                              </tbody>
                            </table>
                          </div>
              @if(isset($internalrequisition->stocks))
              @if($internalrequisition->stocks[0]->estimated_total != null)
             <div class="row">
    

                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  size="5">Sub Total</td>
    <td><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{$internalrequisition->stocks->sum('estimated_total')}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td size="5">Sales Tax (15.0%)</td>
    @if($internalrequisition->tax_confirmed===0)
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internalrequisition->stocks->sum('estimated_total') * 0) }}" style='border:none;outline:none;background: transparent;'></td>
  @else
  <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internalrequisition->stocks->sum('estimated_total') * .15) }}" style='border:none;outline:none;background: transparent;'></td>
  @endif
    </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{$internalrequisition->estimated_cost}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
      @endif
      @endif



                      <div class="form-group row">
                    
                        <label for="date-of-last" class="col-sm-2 col-form-label">Budget Confirm</label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="budget_option" id="budget_option" required>
                          <option value="">Option</option>
                          <option value=1>Yes</option>
                          <option value=0>No</option>
                        
                        </select>  
                        
                        
                        </div>
                        </div>

                        <div id="budget_confirm">
                        <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Commitment No:</label>
                        <div class="col-sm-4">
                        <input type="text" name="commitment_no" id="commitment_no" class="form-control" value="">
                        </div> 
                        <label for="institute" class="col-sm-2 col-form-label">Accounting Code:</label>
                        <div class="col-sm-4">
                        <input type="text" name="account_code" id="account_code" class="form-control" value="">
                        </div>
                        </div>
                        </div>

                        <div id="budget_unconfirmed">
                          <div class="form-group row">
                            <label for="institute" class="col-sm-2 col-form-label">Refusal Comments</label>
                            <div class="col-sm-4">
                            
                              <textarea class="form-control" id="refuse_comment" name="refuse_comment" rows="5" placeholder="Enter ..."></textarea>
                            </div> 
                           
                            </div>
                            </div>


                          

                          
                        </div>





                      <div class="row">
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Comments/Justification</label>
                          <textarea class="form-control" name="comments" rows="3" disabled>{{$internalrequisition->comments}}</textarea>
                          </div>
                        </div>
                        @if($internalrequisition->comment->isNotEmpty())
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                    <label>Refusal Comments</label>
                    <textarea  class="form-control" rows="3" disabled>
@foreach($internalrequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}} 
{{Carbon\Carbon::parse($comment->created_at)->format('d/M/Y')}}
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
                        
                      </div>

                      
                      
                            
                    <div class="col-10">
                       
                      {{-- <div class="col-sm-5">
                      Approve Internal Requisition by: <span class='badge badge-success'></span>
                      </div> --}}
                      <div class="col-sm-5">
                       @if($internalrequisition->approve_internal_requisition)
                      Approve by: <span class='badge badge-success'>{{$internalrequisition->approve_internal_requisition->user->firstname[0]}}. {{$internalrequisition->approve_internal_requisition->user->lastname}} </span></br>
                      Date:  <span class='badge badge-success'>{{$internalrequisition->approve_internal_requisition->created_at}}</span>
                      @else
                        Approve  by: <span class='badge badge-success'></span>
                        @endif
                      </div>
                    </div>
                    
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-10">
                          {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                          <button type="Submit" id="btnSubmit" class="btn btn-block btn-outline-primary" >Submit</button>
                          </div>
                          </div>
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

$("#budget_commitment_form").submit(function (e) {

    //stop submitting the form to see the disabled button effect
   // e.preventDefault();

    //disable the submit button
    $("#btnSubmit").attr("disabled", true);

    

    return true;

});
});


$("#budget_confirm").hide();
$("#budget_unconfirmed").hide();


$("#budget_option").on('change', function(){
    let option= $(this).val();
    console.log(option);
  if(option == 1){
    $("#budget_unconfirmed").hide();
    $("#budget_confirm").show();
    $("#commitment_no").attr("required", true);
    $("#account_code").attr("required", true);

        }else{
          $("#budget_unconfirmed").show();
          $("#budget_confirm").hide();
          $("#commitment_no").attr("required", false);
          $("#account_code").attr("required", false);

        }
      });




   


  </script>



<script>


</script>
  
 





    @endpush