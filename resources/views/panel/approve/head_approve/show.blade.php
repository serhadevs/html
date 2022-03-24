

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
                        <h3 class="card-title">Head of Entity Approval Procurement Committee (PC)</h3>
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
                        <input type="input" class="form-control"  value="{{$requisition->internalrequisition->created_at->format('d-m-Y')}}" id="date-ordered" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-4">
                       
                          <input type="input" class="form-control"  value="{{$requisition->internalrequisition->requisition_type->name}}" id="date-ordered" readonly>
                      
                      </div>
                      <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                      <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                        <input type="number" class="form-control" placeholder="{{number_format($requisition->internalrequisition->estimated_cost,2)}}" readonly id= 'estimated_cost' readonly>
                        {{-- <input type="hidden" name='id' value="{{$requisition->id}}">  --}}
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
                        
                        </div>
                         <label for="date-of-last" class="col-sm-2 col-form-label">Supplier Address</label>
                        <div class="col-sm-4">
                         
                        <input type="text" class="form-control" value="{{$requisition->supplier->address}}" id='address' readonly>
                         
                        </div>
                        </div>

                        <div class="form-group row">
                          <label for="currency_type" class="col-sm-2 col-form-label">Currency</label>
                         
                          <div class="col-sm-4">
                            <input type="input" value="{{$requisition->internalrequisition->currency->abbr}}" class="form-control" readonly required>
                          </div> 
                          <label for="date-of-last" class="col-sm-2 col-form-label">Tax</label>
                          <div class="col-sm-4">
                           <input type="input" class="form-control" value="{{$requisition->tax_confirmed ===1 ? "Yes":"No" }}"  id="tax" required readonly>
                          </div>
                          </div>
                          <div class="form-group row">
                            <label for="date-of-last" class="col-sm-2 col-form-label">Percentage Variance</label>
                            <div class="col-sm-4">
                             
                             
                            <input type="number" class="form-control" value="{{$requisition->cost_variance}}" id='cost_variance'  readonly>
                            </div>
    
                            <label for="date-of-last"  class="col-sm-2 col-form-label">TRN</label>
                            <div class="col-sm-4">
                             
                             <input type="number" disabled class="form-control" value="{{$requisition->supplier->trn}}" id='trn' >
                             
                            </div>
                            
                            </div>
                      

                        <div class="form-group row">
                          <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                          <div class="col-sm-4">
                              <textarea type="text" class="form-control" disabled >{{$requisition->description}}</textarea>
                          </div>
                          <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                          <div class="col-sm-4">
                            <input type="input" class="form-control" value="{{$requisition->category->name}}"  disabled>                   
                          </div>
                          </div>

                     

                          <div class="form-group row">
                            <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                            <div class="col-sm-4">
                            <span style="position: absolute; margin-left: 1px; margin-top: 6px;">$</span>
                            <input type="number" class="form-control" value="{{$requisition->contract_sum}}" id="contract_sum" disabled  >
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
                              <select type="input" class="form-control"  id="advertisement_method" readonly required>
                                <option value="{{$requisition->advertisement_method->id}}">{{$requisition->advertisement_method->name}}</option>
                              </select> 
                              </div>
                              <label for="tender_opening" class="col-sm-2 col-form-label">Tender Opening</label>
                              <div class="col-sm-4">
                              <span style="position: absolute; margin-left: 1px; margin-top: 6px;"></span>
                              <input type="date" value= "{{$requisition->tender_opening}}"class="form-control" id="tender_opening"  readonly required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="tender_from" class="col-sm-2 col-form-label">Tender Period From</label>
                              <div class="col-sm-4">
                              <input type="date"  class="form-control" value= "{{$requisition->tender_from}}" id="tender_from"  readonly  required>
                              </div>
                              <label for="tender_to" class="col-sm-2 col-form-label">Tender Period To</label>
                              <div class="col-sm-4">
                              <input type="date" class="form-control" value= "{{$requisition->tender_to}}" id="tender_to" readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">Tender Bond Request</label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control"  id="tender_bond" readonly  required>
                                <option selected value={{$requisition->tender_bond}}>{{$requisition->tender_bond ===1 ? "Yes":"No" }}</option>
                              </select> 
                              </div>
                              <label for="number_days" class="col-sm-2 col-form-label">Number of days</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->number_days}}" id="number_days" readonly required>
                              </div>
                              </div>
                              
                              <div class="form-group row">
                              <label for="bid_request" class="col-sm-2 col-form-label">Bid Request</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->bid_request}}" id="bid_request"  readonly  required>
                              </div>
                              <label for="bid_received" class="col-sm-2 col-form-label">Bid Received</label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value= "{{$requisition->bid_received}}" id="bid_received" readonly  required>
                              </div>
                              </div>
                              <div class="form-group row">
                                <label for="bid_val" class="col-sm-2 col-form-label">Bid Validity</label>
                                <div class="col-sm-4">
                                <input type="number" class="form-control" value= "{{$requisition->validity}}" id="validity" readonly  required>
                                </div>
                                <label for="bid_received" class="col-sm-2 col-form-label">Expiration Date</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value= "{{$requisition->expiration_date}}" id="expiration_date"  readonly required>
                                </div>
                                </div>
                              
                               
                                @endif

                            <div class='above'>

                              <div class="form-group row">
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                              <div class="col-sm-4">
                              <input type="number" class="form-control" value="{{$requisition->tcc}}"  disabled>
                              </div>
                              <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                             
                              <div class="col-sm-4">
                              <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                              <input type="text" class="form-control datepicker-input" id='tcc_expired_date' value='{{$requisition->tcc_expired_date}}' data-target="#tcc_expired" disabled/>
                              
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
                              
                              </div>
                              
                              </div>
                              
                              </div>
      
                              
      
      
                             </div>



            
                             <div class="form-group row">
                                <label for="meeting_type" class="col-sm-2 col-form-label">Meeting Type</label>
                                <div class="col-sm-4">
                                <input type="input" value="{{$requisition->committee->meeting_type->name}}" class="form-control"name ='meeting_type_id' id="meeting_type" readonly required>
                                </div>

                                <label for="cost-centre" class="col-sm-2 col-form-label">Submission</label>
                                <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{$requisition->committee->date_submission}}"name ='submission' id="submission" readonly required>
                                </div>
                                
                                </div>
                             

                                <div class="form-group row">
                                    <label for="action_taken" class="col-sm-2 col-form-label">Action Taken</label>
                                    <div class="col-sm-4">
                                    <input type="input"  value ="{{$requisition->committee->action_taken->name}}" class="form-control"name ='action_taken_id' id="action_taken" readonly required>
                                </div>
                                
                          
                                <label for="location"  class="col-sm-2 col-form-label">Location</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$requisition->committee->laction}}" id='location' name='location'readonly>
                                </div> 
                        
                                    </div>

                                    <div class="hidden">
                                    <div class="form-group row hiddens">
                                    <label for="date-of-last" class="col-sm-2 col-form-label">Last Signatory</label>
                                    <div class="col-sm-4">
                                    <input type="date" class="form-control" value="{{$requisition->committee->laction}}" id='signatory' name='signatory' readonly>
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
                                        @foreach ($requisition->committee->members as $member )
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
                                                        @foreach(App\File_Upload::where('requisition_id',$requisition->id)->get() as $file)
                                                        <tr> 
                                                        <td>
                                                        <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' style='border:none;outline:none;background: transparent;' required>
                                                        </td> 
                                                      <td> <a class="btn btn-primary " href="{{ asset('/documents/'.$file->filename)}}">View</a></td>
                                                        <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled >Remove</button></td>
                                                      </tr>
                                                        @endforeach
                                                      </tbody>
                                                       <tbody>
                                                        @foreach($requisition->internalrequisition->attached as $file)
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
                        @if($requisition->approve_count === 1)
                        Approve Requisition by:  <span class='badge badge-success'>{{$requisition->approve->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->approve->created_at}}</span></br> 
                        @endif
                        @endif

                        @if(isset($requisition->approve))
                          @if($requisition->approve_count >= 2)
                          @foreach($requisition->approve->where('requisition_id',$requisition->id)->get() as $key=> $approve)
                          {{$approve->user->role->name}} : <span class='badge badge-success'> {{$approve->user->abbrName()}}</span></br>

                          @endforeach
                          @endif
                          @endif
                          @if(isset($requisition->entity_head_approve))
                          Regional Director by:  <span class='badge badge-success'>{{$requisition->entity_head_approve->user->abbrName()}}</span></br>
                          Date:<span class='badge badge-success'>{{$requisition->entity_head_approve->created_at}}</span></br> 
                          @endif
                  
                 
                      </div>
                    
                      </div>  
                   
                      </div> 





                      </div> 

                     



                        </div>
                        <div class="row">
                          <div class="col-10">
                            @if($requisition->entity_head_approve)
                            <button type="button"   class="btn btn-warning btn-lg" disabled>Refuse</button>
                            <button type="button"   class="btn btn-primary float-right btn-lg" disabled>Approve</button></br>
                             @else
                             <button type="button" id="btnrefuse"  class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                             <button type="button" id="btnapprove"   class="btn btn-outline-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');" >Approve</button></br>
                            @endif
                            </div>
                        </div>




                               {{-- //modal  --}}

             <div class="modal fade" id="modal-lg">
              <div class="modal-dialog modal-m">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Refuse Requisition</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <div class="card-body">
                      <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/approve-budget-requisition" >
                        @csrf 
                         <div class="form-group row">
                        <label for="cost-centre" class="col-m-4 col-form-label">Comments</label>
                        <div class="col-m-8">
                            <textarea type="text" style="width:400px; height:200px;" value="{{Request::old('comment')}}" id="comment" name='comment'></textarea>
                        </div>
                        <input type="hidden" name='requisition_id' id="requisition_id" value="{{$requisition->id}}"> 
                        </div>


                     
                    </form>

            
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-outline-primary float-right btn-lg" id="post" onclick="Refuse('{{$requisition->id}}');">Send</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>




            {{-- //end --}}
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






  </script>
  <script>

    function Accept(requisitionId){
       swal({
            title: "Are you sure you want to approve the selected purchase requisition?",
            text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
            icon: "warning",
            buttons: [
              'No, cancel it!',
              'Yes, I am sure!'
            ]
          }).then(isConfirm => {
            if (isConfirm) {
              // console.log("app type:" +  requisitionId);
              $.post( {!! json_encode(url('/')) !!} + "/entity_head_approve",{ _method: "POST",data:{requisitionId:requisitionId,permission:1},_token: "{{ csrf_token() }}"}).then(function (data) {
              console.log(data);
                if (data == "success") {
                  swal(
                    "Done!",
                    "Procurement Committee was approved and will shortly be forwarded for Purchase Order.",
                    "success").then(esc => {
                      if(esc){
                       // location.reload();
                      location.href='/entity_head_approve';
                      }
                    });
                  }else{
                    swal(
                      "Oops! Something went wrong.",
                      "Application(s) were NOT approved",
                      "error");
                       location.reload();
                    }
               
                    
                   
                  });
                }
           
            });
    }
    
    
    function Refuse(requisitionId){
      var comment = $('#comment').val();
      // console.log(internal_requisition_id);
       swal({
            title: "Are you sure you want to refuse the selected applications?",
            // text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
            icon: "warning",
            buttons: [
              'No, cancel it!',
              'Yes, I am sure!'
            ]
          }).then(isConfirm => {
            if (isConfirm) {
              // console.log("app type:" +  requisitionId);
              $.post( {!! json_encode(url('/')) !!} + "/entity_head_approve",{ _method: "POST",data:{requisitionId:requisitionId,permission:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
              console.log(data);
                if (data == "success") {
                  swal(
                    "Done!",
                    "Procurement Committee was refuse and will send an email to the requester.",
                    "success").then(esc => {
                      if(esc){
                        location.reload();
                      }
                    });
                  }else{
                    swal(
                      "Oops! Something went wrong.",
                      "Application(s) were NOT approved",
                      "error");
                    }
                    location.href='/entity_head_approve';
                   
                  });
                }
           
            });
            $('#modal-lg').modal('hide');
    }
    
   
      
    </script>
  @endpush