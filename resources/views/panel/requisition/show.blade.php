

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
                        <a href="/pdf_requisition/{{$requisition->id}}" class="btn btn-outline-danger float-right btn-lg">Print PDF</a>
                        <br>
                        </div>
          
                </section>
            
      <div class="card-body">

                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}"  enctype="multipart/form-data" >
                  @csrf
                  @method('PATCH')  --}}
            
    
                        <div id="first">
                            <div class="card" style="width:83.6%">
                          <div class="card-body">
                           <div class="col-m-10">

                           
                             <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$requisition->internalrequisition->user->abbrName()}}" readonly>
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Department</label>
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
                        <input type="number" class="form-control" placeholder="{{number_format($requisition->internalrequisition->estimated_cost,2)}}" readonly id= 'estimated_cost' name='estimated_cost' read>
                       
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
                           <select type="input" class="form-control" name="delivery" id="delivery" required disabled>
                          <option selected value="{{strtoupper($requisition->delivery)}}"  >{{strtoupper($requisition->delivery)}} </option>
                          
                         </select>  
                       
                         
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
                           <select type="input" class="form-control" name="tax" id="tax" required readonly>
                            <option selected value={{$requisition->tax_confirmed}}>{{$requisition->tax_confirmed ===1 ? "Yes":"No" }} </option>     
                           </select>  
                          
                           
                          </div>
                          </div>
                          <div class="form-group row">
                            <label for="date-of-last" class="col-sm-2 col-form-label">Percentage Variance</label>
                            <div class="col-sm-4">
                             
                             
                            <input type="number" class="form-control" value="{{$requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                            </div>
    
                            <label for="date-of-last"  class="col-sm-2 col-form-label">TRN</label>
                            <div class="col-sm-4">
                             
                             <input type="number" disabled class="form-control" value="{{$requisition->supplier->trn}}" id='trn' name='trn'>
                             
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
                            <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" class="form-control" value="{{$requisition->contract_sum}}" id="contract_sum" disabled  name='contract_sum'>
                            </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->procurement_method->name}}"  disabled>
                          </div>
                            </div>
                            @if($requisition->advertisement_method != null)
                            <div class="form-group row">
                              <label for="advertisement_method" class="col-sm-2 col-form-label">Method of advertisement </label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control" name="advertisement_method" id="advertisement_method" readonly required>
                                <option value="{{$requisition->advertisement_method->id}}">{{$requisition->advertisement_method->name}}</option>
                              </select> 
                              </div>
                              <label for="tender_opening" class="col-sm-2 col-form-label">Tender Opening</label>
                              <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;"></span>
                              <input type="date" value= "{{$requisition->tender_opening}}"class="form-control" id="tender_opening" name='tender_opening' readonly required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="tender_from" class="col-sm-2 col-form-label">Tender Period From</label>
                              <div class="col-sm-4">
                              <input type="date"  class="form-control" value= "{{$requisition->tender_from}}" id="tender_from" name='tender_from' readonly  required>
                              </div>
                              <label for="tender_to" class="col-sm-2 col-form-label">Tender Period To</label>
                              <div class="col-sm-4">
                              <input type="date" class="form-control" value= "{{$requisition->tender_to}}" id="tender_to" name='tender_to' readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Tender Bond Request</label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control" name="tender_bond" id="tender_bond" readonly  required>
                                <option selected value={{$requisition->tender_bond}}>{{$requisition->tender_bond ===1 ? "Yes":"No" }}</option>
                              </select> 
                              </div>
                              <label for="number_days" class="col-sm-2 col-form-label">Number of days</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->number_days}}" id="number_days" name='number_days' readonly required>
                              </div>
                              </div>
                              
                              <div class="form-group row">
                              <label for="bid_request" class="col-sm-2 col-form-label">Bid Request</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->bid_request}}" id="bid_request" name='bid_request' readonly  required>
                              </div>
                              <label for="bid_received" class="col-sm-2 col-form-label">Bid Received</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->bid_received}}" id="bid_received" name='bid_received' readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                                <label for="bid_val" class="col-sm-2 col-form-label">Bid Validity</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" value= "{{$requisition->validity}}" id="validity" name="validity" readonly  required>
                                </div>
                                <label for="bid_received" class="col-sm-2 col-form-label">Expiration Date</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value= "{{$requisition->expiration_date}}" id="expiration_date" name="expiration_date" readonly required>
                                </div>
                                </div>
                              
                                <div class="form-group row">
                                <label for="transport" class="col-sm-2 col-form-label">Transport Cost</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" value= "{{$requisition->transport_cost}}" id="transport_cost" name="transport_cost" readonly  required>
                                </div>
                              
                                <div class="col-sm-4">
                                
                                </div>
                                </div>
                                @endif

                            <div class='above'>

                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value="{{$requisition->tcc}}" name='tcc' disabled>
                              </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='tcc_expired_date' id='tcc_expired_date' value='{{$requisition->tcc_expired_date}}' data-target="#tcc_expired" disabled/>
                              <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              </div>
                              
                              </div>
                              
                              </div>
      
                               <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$requisition->ppc}}" name='ppc' disabled>
                                </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='ppc_expired_date' id='ppc_expired_date' value='{{$requisition->ppc_expired_date}}' data-target="#ppc_expired" disabled/>
                              <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                              </div>
                              
                              </div>
                              
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
                {{-- <th class="text-center">Unit Cost</th>
                <th class="text-center">Estimated Total</th> --}}
                <th class="text-center">Actual Unit Cost</th>
                <th class="text-center">Total</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($requisition->internalrequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->unit_of_measurement->name}}</td>
                {{-- <td>{{$stock->unit_cost}}</td>
                <td>{{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2)}}</td> --}}
                <td>${{number_format($stock->actual_cost,2)}}</td>
                <td>${{number_format($stock->actual_total,2)}}</td>
            
       
              
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
    @if($requisition->tax_confirmed===0)
     <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * 0,2) }}" style='border:none;outline:none;background: transparent;'></td>
    @else
    <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * .15,2) }}" style='border:none;outline:none;background: transparent;'></td>
    @endif
    </tr>
    @if($requisition->transport_cost != null)
    <tr>
      <td style='width:20px;'>Transport Cost</td>
      <td style='width:20px;'><input id='transport' value="${{number_format($requisition->transport_cost,2)}}" readonly type='text' value="0.0" size="10" style='border:none;outline:none;background: transparent;'></td>
    </tr>
    @endif
   <tr>
    <td  style='width:20px;'>Grand Total</td>
     <td style='width:20px;'><input id='grandtotal' readonly type='text' value="${{number_format($requisition->contract_sum,2)}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
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

                      <div class="form-group row">
                      <div class="col-sm-6">
                        Approve IRF by: <span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
                      
                        @if($requisition->check)
                        Accepted by: <span class='badge badge-success'>{{$requisition->check->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->check->created_at}}</span></br>
                        @endif
                      </div>
                      <div class="col-sm-6">
                        Budget Approve by: <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->created_at}}</span><br>
                        
                        @if($requisition->approve)
                        Approve Requisition by:  <span class='badge badge-success'>{{$requisition->approve->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->approve->created_at}}</span></br> 
                        @endif
                  
                 
                      </div>
                    
                      </div> 
                   
                      </div> 





                      </div> 

                     



                        </div>
                        <div class="row">
                        <div class="col-10">
                       
                        <a type="button" href="/requisition"   class="btn btn-outline-success float-left btn-lg">Back</a>
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



// $('#contract_sum').on('input',function(){
// let cost_variance;
// var contractSum = parseFloat($('#contract_sum').val());
// var estimated_cost = parseFloat($('#estimated_cost').val());
// //var requisition_type = $('#requisition_type').val());
// if(contractSum >= 1500000){
//  $('.above').show();
//  console.log(requisition_type);
// }else{
//   $('.above').hide();
// }

// });



$(document).ready(function(){
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