

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
                        <h3 class="card-title">Show Commitment Budget</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="">
                 
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">


                            <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->user->abbrName()}}" readonly>
                                
                                </div>
        
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$budgetCommitment->internalrequisition->created_at->format('d-m-Y')}}" name='date_ordered' id="date-ordered" readonly>
                                </div>
                                
                              </div>
                                  <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->institution->name}}" readonly>
                                  {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                                  </div>
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->department->name}}" readonly>
                                </div>
                                
                              </div>
                              
        
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{$budgetCommitment->internalrequisition->estimated_cost}}" name='estimated_cost' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->budget_approve}}" readonly>
                                </div>
                                </div>
        
                                
                                
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                                <div class="col-sm-4">
                                    <input type="tele" class="form-control" value="{{$budgetCommitment->internalrequisition->phone}}" name='phone' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                                <div class="col-sm-4">
                                 
                                 <input type="email" class="form-control" value="{{$budgetCommitment->internalrequisition->email}}" id='email' name='email' readonly>
                                 
                                </div>
                                </div>
        
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Procurement</label>
                                <div class="col-sm-4">
                                    <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->requisition_type->name}}" readonly>
                                
                                </div> 
                                <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->priority}}" readonly>
                                 
                                </div>
                                </div>
                                <div class="form-group row">
                                  <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                                 
                                  <div class="col-sm-4">
                                    <select type="input" class="form-control" name="currency_type" id="currency_type" readonly required>
                                    
                                  <option selected value="{{$budgetCommitment->internalrequisition->currency->id}}">{{$budgetCommitment->internalrequisition->currency->abbr}}</option>
                                     </select>  
                                   </select>  
                                  
                                  </div> 
                                  <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                                  <div class="col-sm-4">
                                   <select type="input" class="form-control" name="tax" id="tax" readonly required>
                                    <option selected value="{{$budgetCommitment->internalrequisition->tax_confirmed}}">{{$budgetCommitment->internalrequisition->tax_confirmed === 1 ? "Yes" : "no"}}</option>
        
                                   </select>  
                                  
                                   
                                  </div>
                                  </div>
                                <div class="form-group row">
                                  <label for="cost-centre" class="col-sm-2 col-form-label">Requisition no.</label>
                                  <div class="col-sm-4">
                                      <input type="input" class="form-control" value="{{$budgetCommitment->internalrequisition->requisition_no}}" readonly>
                                  
                                  </div> 
                                    <label  for="cost-centre" class="col-sm-2 col-form-label">General Description</label>
                                  <div class="col-sm-4">
                                   <textarea  readonly class="form-control" name="comments" rows="3">{{$budgetCommitment->internalrequisition->description}}</textarea>
                                   
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
                                @foreach($budgetCommitment->internalrequisition->stocks as $stock)
                                <tr>
                                
                                  <td>{{$stock->item_number}}</td>
                                  <td>{{$stock->description}}</td>
                                  <td>{{$stock->quantity}}</td>
                                  <td>{{$stock->unit_of_measurement_id}}</td>
                                  <td>{{$stock->unit_cost}}</td>
                                  <td>{{$stock->estimated_total}}</td>
                              
                         
                                
                                </tr>
                                 
                             @endforeach
                           
                    
                              </tbody>
                            </table>
                          </div>
                          @if($budgetCommitment->internalrequisition->stocks[0]->estimated_total != null)
             <div class="row">
    

                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  size="5">Sub Total</td>
    <td><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{$budgetCommitment->internalrequisition->stocks->sum('estimated_total')}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td size="5">Sales Tax (15.0%)</td>
    @if($budgetCommitment->internalrequisition->tax_confirmed===0)
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($budgetCommitment->internalrequisition->stocks->sum('estimated_total') * 0) }}" style='border:none;outline:none;background: transparent;'></td>
    @else
    <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($budgetCommitment->internalrequisition->stocks->sum('estimated_total') * .15) }}" style='border:none;outline:none;background: transparent;'></td>
    @endif
    </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{$budgetCommitment->internalrequisition->estimated_cost}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
      @endif






                        
      <div class="form-group row">
                    
        <label for="date-of-last" class="col-sm-2 col-form-label">Budget Confirm</label>
        <div class="col-sm-4">
        <select type="input" class="form-control" name="budget_option" id="budget_option" required readonly disabled>
          <option selected value="{{$budgetCommitment->budget_option}}">{{$budgetCommitment->budget_option ===1 ? "Yes":"No" }}</option>
         @if($budgetCommitment->budget_option !=1 )
          <option value=1>Yes</option>
          @else
          <option value=0>No</option>
         @endif

         
        
        </select>  
        
        
        </div>
        </div>

       
        <div id="budget_confirm">
        <div class="form-group row">
        <label for="institute" class="col-sm-2 col-form-label">Commitment No:</label>
        <div class="col-sm-4">
        <input type="text" name="commitment_no" value = "{{$budgetCommitment->commitment_no}}"class="form-control" readonly value="">
        </div> 
        <label for="institute" class="col-sm-2 col-form-label">Accounting Code:</label>
        <div class="col-sm-4">
        <input type="text" name="account_code" value="{{$budgetCommitment->account_code}}" class="form-control" readonly value="">
        </div>
        </div>
        </div>
     

        <div id="budget_unconfirmed">
          <div class="form-group row">
            <label for="institute" class="col-sm-2 col-form-label">Refusal Comments</label>
            <div class="col-sm-4">
            
              <textarea class="form-control" id="refuse_comment" name="refuse_comment" rows="5" readonly placeholder="Enter ..."></textarea>
            </div> 
           
            </div>
            </div>


          

          
        </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Comments/Justification</label>
                          <textarea class="form-control" name="comments" rows="3" disabled>{{$budgetCommitment->internalrequisition->comments}}</textarea>
                          </div>
                        </div>
                        @if($budgetCommitment->internalrequisition->comment->isNotEmpty())
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                    <label>Refusal Comments</label>
                    <textarea  class="form-control" rows="3" disabled>
@foreach($budgetCommitment->internalrequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}}
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
                    @foreach($budgetCommitment->internalrequisition->attached as $file)
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

                      
                      
                    </div>
                            
                    <div class="col-10">
                       
                      {{-- <div class="col-sm-5">
                      Approve Internal Requisition by: <span class='badge badge-success'></span>
                      </div> --}}
                      <div class="col-sm-5">
                       @if($budgetCommitment->internalrequisition->approve_internal_requisition)
                      Approve by: <span class='badge badge-success'>{{$budgetCommitment->internalrequisition->approve_internal_requisition->user->firstname[0]}}. {{$budgetCommitment->internalrequisition->approve_internal_requisition->user->lastname}} </span></br>
                      Date:  <span class='badge badge-success'>{{$budgetCommitment->internalrequisition->approve_internal_requisition->created_at}}</span>
                      @else
                        Approve  by: <span class='badge badge-success'></span>
                        @endif
                      </div>
                    </div>
                    
                  </br>
                        </div>
                    



                        <div class="row">
                            <div class="col-10">
                            <a type="button"  href="/budgetcommitment" class="btn btn-outline-success">Back</a>
                            
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
  

$("#budget_option").on('change', function(){
    let option= $(this).val();
    console.log(option);
  if(option == 1){
    $("#budget_unconfirmed").hide();
    $("#budget_confirm").show();

        }else{
          $("#budget_unconfirmed").show();
          $("#budget_confirm").hide();
        }
      });



      $(document).ready(function(){
    
        let option= $("#budget_option").val();
    console.log(option);
  if(option == 1){
    $("#budget_unconfirmed").hide();
    $("#budget_confirm").show();

        }else{
          $("#budget_unconfirmed").show();
          $("#budget_confirm").hide();
        }
      });







  </script>



<script>


</script>
  
 





    @endpush