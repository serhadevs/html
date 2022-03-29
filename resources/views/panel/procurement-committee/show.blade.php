

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
.hidden{
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
                        <h3 class="card-title">Show Procurement Committee (PC)- Approval Form</h3>
                        </div>
                        </div>

                     
                        </div>
          
                </section>
            
      <div class="card-body">
       
        
                        <div id="first">
                            <div class="card" style="width:83.6%">
                          <div class="card-body">
                           <div class="col-m-10">

                           
                             <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$procurementCommittee->requisition->internalrequisition->user->abbrName()}}" readonly>
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-4">
                          <input type="input" class="form-control" value="{{$procurementCommittee->requisition->department->name}}" readonly>
                        </div>
                      </div>
                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" value="{{$procurementCommittee->requisition->institution->name}}" readonly>
                          {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                          </div>

                        <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control"  value="{{$procurementCommittee->requisition->internalrequisition->created_at->format('d-m-Y')}}" id="date-ordered" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                       
                          <input type="input" class="form-control"  value="{{$procurementCommittee->requisition->internalrequisition->requisition_type->name}}" id="date-ordered" readonly>
                      
                      </div>
                      <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                      <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                        <input type="number" class="form-control" placeholder="{{number_format($procurementCommittee->requisition->internalrequisition->estimated_cost,2)}}" readonly id= 'estimated_cost' readonly>
                        {{-- <input type="hidden" name='id' value="{{$requisition->id}}">  --}}
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Cost Centre </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$procurementCommittee->requisition->cost_centre}}" name='cost_centre' disabled>
                        </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Commitment #</label>
                        <div class="col-sm-4">
                         
                         <input type="input" class="form-control" value="{{$procurementCommittee->requisition->commitment_no}}" name='commitment' disabled>
                         
                        </div>
                        </div>
                         <div class="form-group row">
                              <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                              <div class="col-sm-4">
                              <input type="input" class="form-control" value="{{$procurementCommittee->requisition->requisition_no}}" readonly>
                                </div>
                        <label for="date-of-last" class="col-sm-2 col-form-label">Terms</label>
                        <div class="col-sm-4">
                           <select type="input" class="form-control" name="delivery" id="delivery" required disabled>
                          <option selected value="{{strtoupper($procurementCommittee->requisition->delivery)}}"  >{{strtoupper($procurementCommittee->requisition->delivery)}} </option>
                          
                         </select>  
                       
                         
                        </div>
                              
                            </div>
                      
                         <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Recommended Supplier </label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$procurementCommittee->requisition->supplier->name}}"  disabled>
                        
                        </div>
                         <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Address</label>
                        <div class="col-sm-4">
                         
                        <input type="text" class="form-control" value="{{$procurementCommittee->requisition->supplier->address}}" id='address' readonly>
                         
                        </div>
                        </div>

                        <div class="form-group row">
                          <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                         
                          <div class="col-sm-4">
                            <input type="input" value="{{$procurementCommittee->requisition->internalrequisition->currency->abbr}}" class="form-control" readonly required>
                          </div> 
                          <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                          <div class="col-sm-4">
                           <input type="input" class="form-control" value="{{$procurementCommittee->requisition->tax_confirmed ===1 ? "Yes":"No" }}"  id="tax" required readonly>
                          </div>
                          </div>
                          <div class="form-group row">
                            <label for="date-of-last" class="col-sm-2 col-form-label">Percentage Variance</label>
                            <div class="col-sm-4">
                             
                             
                            <input type="number" class="form-control" value="{{$procurementCommittee->requisition->cost_variance}}" id='cost_variance'  readonly>
                            </div>
    
                            <label for="date-of-last"  class="col-sm-2 col-form-label">TRN</label>
                            <div class="col-sm-4">
                             
                             <input type="number" disabled class="form-control" value="{{$procurementCommittee->requisition->supplier->trn}}" id='trn' >
                             
                            </div>
                            
                            </div>
                      

                        <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                          <div class="col-sm-4">
                              <textarea type="text" class="form-control" disabled >{{$procurementCommittee->requisition->description}}</textarea>
                          </div>
                          <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$procurementCommittee->requisition->category->name}}"  disabled>                   
                          </div>
                          </div>

                     

                          <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                            <div class="col-sm-4">
                            <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" class="form-control" value="{{$procurementCommittee->requisition->contract_sum}}" id="contract_sum" disabled  >
                            </div>
                            <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$procurementCommittee->requisition->procurement_method->name}}"  disabled>
                          </div>
                            </div>
                            @if($procurementCommittee->requisition->advertisement_method != null)
                            <div class="form-group row">
                              <label for="advertisement_method" class="col-sm-2 col-form-label">Method of advertisement </label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control"  id="advertisement_method" readonly required>
                                <option value="{{$procurementCommittee->requisition->advertisement_method->id}}">{{$procurementCommittee->requisition->advertisement_method->name}}</option>
                              </select> 
                              </div>
                              <label for="tender_opening" class="col-sm-2 col-form-label">Tender Opening</label>
                              <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;"></span>
                              <input type="date" value= "{{$procurementCommittee->requisition->tender_opening}}"class="form-control" id="tender_opening"  readonly required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="tender_from" class="col-sm-2 col-form-label">Tender Period From</label>
                              <div class="col-sm-4">
                              <input type="date"  class="form-control" value= "{{$procurementCommittee->requisition->tender_from}}" id="tender_from"  readonly  required>
                              </div>
                              <label for="tender_to" class="col-sm-2 col-form-label">Tender Period To</label>
                              <div class="col-sm-4">
                              <input type="date" class="form-control" value= "{{$procurementCommittee->requisition->tender_to}}" id="tender_to" readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Tender Bond Request</label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control"  id="tender_bond" readonly  required>
                                <option selected value={{$procurementCommittee->requisition->tender_bond}}>{{$procurementCommittee->requisition->tender_bond ===1 ? "Yes":"No" }}</option>
                              </select> 
                              </div>
                              <label for="number_days" class="col-sm-2 col-form-label">Number of days</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$procurementCommittee->requisition->number_days}}" id="number_days" readonly required>
                              </div>
                              </div>
                              
                              <div class="form-group row">
                              <label for="bid_request" class="col-sm-2 col-form-label">Bid Request</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$procurementCommittee->requisition->bid_request}}" id="bid_request"  readonly  required>
                              </div>
                              <label for="bid_received" class="col-sm-2 col-form-label">Bid Received</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$procurementCommittee->requisition->bid_received}}" id="bid_received" readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                                <label for="bid_val" class="col-sm-2 col-form-label">Bid Validity</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" value= "{{$procurementCommittee->requisition->validity}}" id="validity" readonly  required>
                                </div>
                                <label for="bid_received" class="col-sm-2 col-form-label">Expiration Date</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value= "{{$procurementCommittee->requisition->expiration_date}}" id="expiration_date"  readonly required>
                                </div>
                                </div>
                              
                               
                                @endif

                            <div class='above'>

                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value="{{$procurementCommittee->requisition->tcc}}"  disabled>
                              </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" id='tcc_expired_date' value='{{$procurementCommittee->requisition->tcc_expired_date}}' data-target="#tcc_expired" disabled/>
                              
                              </div>
                              
                              </div>
                              
                              </div>
      
                               <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$procurementCommittee->requisition->ppc}}" name='ppc' disabled>
                                </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" name='ppc_expired_date' id='ppc_expired_date' value='{{$procurementCommittee->requisition->ppc_expired_date}}' data-target="#ppc_expired" disabled/>
                              
                              </div>
                              
                              </div>
                              
                              </div>
      
                              
      
      
                             </div>



            
                             <div class="form-group row">
                                <label for="meeting_type" class="col-sm-2 col-form-label">Meeting Type</label>
                                <div class="col-sm-4">
                                <input type="input" value="{{$procurementCommittee->meeting_type->name}}" class="form-control"name ='meeting_type_id' id="meeting_type" readonly required>
                                </div>
                                @if(empty($procurementCommittee->date_last_signatory))
                                <label for="cost-centre" class="col-sm-2 col-form-label">Meeting Date</label>
                                <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{$procurementCommittee->date_submission}}"name ='submission' id="submission" readonly required>
                                </div>
                                @else
                                <label for="date-of-last" class="col-sm-2 col-form-label">Last Date Signatory</label>
                                <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{$procurementCommittee->date_last_signatory}}" id='signatory' name='signatory' readonly>
                                </div>

                                @endif
                                
                                </div>
                             

                                <div class="form-group row">
                                    <label for="action_taken" class="col-sm-2 col-form-label">Action Taken</label>
                                    <div class="col-sm-4">
                                    <input type="input"  value ="{{$procurementCommittee->action_taken->name}}" class="form-control"name ='action_taken_id' id="action_taken" readonly required>
                                </div>
                                
                                @if(!empty($procurementCommittee->location))
                                <label for="location"  class="col-sm-2 col-form-label">Location</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$procurementCommittee->location}}" id='location' name='location'readonly>
                                </div> 
                                @endif
                        
                                    </div>

                                    <div class="hidden">
                                    <div class="form-group row hiddens">
                                    <label for="date-of-last" class="col-sm-2 col-form-label">Last Date Signatory</label>
                                    <div class="col-sm-4">
                                    <input type="date" class="form-control" id='signatory' name='signatory' readonly>
                                    </div>


                                </div>    
                            </div>
                            <div class="hide">    
                            <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Comments</label>
                              <div class="col-sm-4">
                                  <textarea type="text" rows="5" cols="200"  class="form-control" value="{{Request::old('comments')}}" id="comments" name='comments' readonly></textarea>
                              </div>
                            </div>
                             
                             
                              </div>
                                
                            
                        

                                    <div class="row">
                                        <div class="col-sm-12">
                                          <div id="table" class="table-editable">
                                            {{-- <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"> --}}
                                          
                                          
                                        <table id="stock-table" class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Decision</th>
                                        <th class="text-center">Signature</th>
                                        <th class="text-center">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($procurementCommittee->members as $member )
                                        <tr>
                                        <td>
                                          {{$member->name }}
                                        </td>
                                            <td>
                                            
                                           {{($member->decision ===1) ? ('Endorsed') : (($member->decision ===2) ? ('Rejected') : ('Deferred'))}}
                                               
                                            </td>
                                            <td>
                                           {{$member->signature }}
                                            </td>
                                            
                                            <td>
                                            {{$member->date }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        
                                     
                                       
                                        
                                      
                                        </table>
                                        </div>
                                        </div>
                                        </div>
                         

                         
                                        @if($procurementCommittee->requisition->internalrequisition->comment->isNotEmpty())
                                        <div class="col-sm-6">
                                          <!-- textarea -->
                                          <div class="form-group">
                                            <label>Refusal Comments</label>
                                    <textarea class="form-control" rows="3" disabled>
@foreach($procurementCommittee->requisition->internalrequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}} 
{{Carbon\Carbon::parse($comment->created_at)->format('d/M/Y')}}
@endforeach
                                    </textarea>
                                          </div>
                                        </div>
                                        @endif
                                         <div class="col-sm-6">
                                                                <label for="exampleInputFile">Support Documents</label>
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
                                                        @foreach(App\File_Upload::where('requisition_id',$procurementCommittee->requisition->id)->get() as $file)
                                                        <tr> 
                                                        <td>
                                                        <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' style='border:none;outline:none;background: transparent;' required>
                                                        </td> 
                                                      <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                                                        <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled >Remove</button></td>
                                                      </tr>
                                                        @endforeach
                                                      </tbody>
                                                       <tbody>
                                                        @foreach($procurementCommittee->requisition->internalrequisition->attached as $file)
                                                        <tr> 
                                                        <td>
                                                        <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' style='border:none;outline:none;background: transparent;' required>
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
                      

        
        

                     
                    <div class="form-group row">
                      <div class="col-sm-6">
                        Approve IRF by: <span class='badge badge-success'>{{$procurementCommittee->requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$procurementCommittee->requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
                      
                        @if($procurementCommittee->requisition->check)
                        Accepted by: <span class='badge badge-success'>{{$procurementCommittee->requisition->check->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$procurementCommittee->requisition->check->created_at}}</span></br>
                        @endif
                        Budget Commitment by: <span class='badge badge-success'>{{$procurementCommittee->requisition->internalRequisition->budget_commitment->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$procurementCommittee->requisition->internalRequisition->budget_commitment->created_at}}</span></br>
                      </div>
                      <div class="col-sm-6">
                        Budget Approve by: <span class='badge badge-success'>{{$procurementCommittee->requisition->internalRequisition->approve_budget->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$procurementCommittee->requisition->internalRequisition->approve_budget->created_at}}</span><br>
                        
                        @if($procurementCommittee->requisition->approve)
                        {{-- {{$procurementCommittee->requisition->approve->where('requisition_id',$procurementCommittee->requisition->id)->count()}} --}}
                        @if($procurementCommittee->requisition->approve->where('requisition_id',$procurementCommittee->requisition->id)->count()=== 1)
                        Approve Requisition by:  <span class='badge badge-success'>{{$procurementCommittee->requisition->approve->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$procurementCommittee->requisition->approve->created_at}}</span></br> 
                        @endif
                        @endif

                        @if(isset($procurementCommittee->requisition->approve))
                          @if($procurementCommittee->requisition->approve->where('requisition_id',$procurementCommittee->requisition->id)->count() > 1)
                          @foreach($procurementCommittee->requisition->approve->where('requisition_id',$procurementCommittee->requisition->id)->get() as $key=> $approve)
                          {{$approve->user->role->name}} : <span class='badge badge-success'> {{$approve->user->abbrName()}}</span></br>
                          Date:<span class='badge badge-success'>{{$procurementCommittee->requisition->approve->created_at}}</span></br> 

                          @endforeach
                          @endif
                          @endif

                          @if(isset($procurementCommittee->requisition->entity_head_approve))
                          Regional Director by:  <span class='badge badge-success'>{{$procurementCommittee->requisition->entity_head_approve->user->abbrName()}}</span></br>
                          Date:<span class='badge badge-success'>{{$procurementCommittee->requisition->entity_head_approve->created_at}}</span></br> 
                          @endif
                  
                 
                      </div>
                    
                      </div>  
                   
                      </div> 





                      </div> 

                     



                        </div>
                        <div class="row">
                        <div class="col-10">
                       
                        <a type="button" href="/procurement-committee"   class="btn btn-outline-primary float-left btn-lg">Back</a>

                        </div>
                        </div>
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
    {{-- <script src="/js/editable-table.js"></script>  --}}
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

    $(document).ready(function () {
var type=$('#meeting_type').val();

if( type ==1){
$('#location').show();
$('#location').attr("required",true)
$('label[for="location"]').show();
$('.hidden').hide();
}else if(type == 3)
 {
 $('.hidden').show();
 $('#location').hide();
 $('#signatory').attr("required",true);
 $('#location').attr("required",false);

$('label[for="location"]').hide();
 }else{
    $('.hidden').hide();
//  $('#location').hide();
// $('label[for="location"]').hide();
$('#signatory').attr("disabled",true);

 }
});

  </script>
  @endpush