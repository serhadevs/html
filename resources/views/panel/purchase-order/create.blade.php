




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}

.title{
text-align: center;
}
.hide{
  display:none;
}
</style>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Purchase Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          </div>
        </div>
     
    </section>
    <!-- Main content -->

          
                 @if(count($errors)>0)
                        <div class="col-m-10">
                  <div class="alert alert-danger">
                 


                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
              </div>
            @endif  
              <div class="card-body">

                <form class="form-horizontal" id='purchase_order_form' method="Post" autocomplete="off" action="/purchase-order" enctype="multipart/form-data">
                  @csrf

                  <div class="card" style="width:82.9%">
                    <div class="card-body">
                     <div class="col-m-10"> 
                  
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p>
                        </div>
                              <h3 class="card-header text-center font-weight-bold text-uppercase py-1">Purchase Order</h3></br>
                    
                      
                              <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$requisition->internalrequisition->user->abbrName()}}" readonly>
                                <input type="hidden" name='id' id="id" value="{{$requisition->id}}"> 
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
                                <label for="date-required" class="col-sm-2 col-form-label">Pro. Method</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control"  value="{{$requisition->procurement_method->name}}"name='procurement_method' id="procurement_method" readonly>
                                   
                                </div>
                              </div>
                              
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Recommended Supplier</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control"  value="{{$requisition->supplier->name}}"name='supplier' id="supplier" readonly>
                                
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Delivery</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control"  value="{{$requisition->delivery}}"name='delivery' id="delivery" readonly>
                                 
                                 
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
                                <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value = "{{$requisition->description}}" readonly name='description'>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control"  value="{{$requisition->category->name}}"name='category' id="category" readonly>
                                
                                 
                                </div>
                                </div>
                                
                                
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">TCC number </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$requisition->tcc}}" name='tcc' readonly>
                                </div>
                                


                                <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                               
                                <div class="col-sm-4">
                                <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                                <input type="text" class="form-control datepicker-input" name='tcc_expired_date' value="{{$requisition->tcc_expired_date}}" data-target="#tcc_expired" readonly/>
                                <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                </div>
                                </div>
                                
                                </div>

                                <div class="form-group row">
                                  <label for="cost-centre" class="col-sm-2 col-form-label">PPC number </label>
                                  <div class="col-sm-4">
                                      <input type="number" class="form-control" value="{{$requisition->ppc}}" name='ppc' readonly>
                                  </div>
                                  
  
  
                                  <label for="cost-centre" class="col-sm-2 col-form-label">PPC Expired </label>
                                 
                                  <div class="col-sm-4">
                                  <div class="input-group date" id="ppc_expired" data-target-input="nearest">
                                  <input type="text" class="form-control datepicker-input" name='ppc_expired_date' value="{{$requisition->ppc_expired_date}}" data-target="#ppc_expired" readonly/>
                                  <div class="input-group-append" data-target="#ppc_expired" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                  </div>
                                  </div>
                                  
                                  </div>
        
                                 <div class="form-group row">
                                  <label for="date-of-last" class="col-sm-2 col-form-label">Supplier TRN</label>
                                  <div class="col-sm-4">
                                   
                                   <input type="number" class="form-control" value="{{$requisition->supplier->trn}}" name='trn' readonly>
                                   
                                  </div>
                               
                                <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                                <div class="col-sm-4">
                                 
                                 <input type="number" class="form-control" placeholder="${{number_format($requisition->internalrequisition->estimated_cost,2)}}" id= 'estimated_cost' name='estimated_cost' readonly>
                                 
                                </div>
                                </div>
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" placeholder="${{number_format($requisition->contract_sum,2)}}" id="contract_sum" name='contract_sum'readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Cost Variance</label>
                                <div class="col-sm-4">
                                 
                                 <input type="number" class="form-control" value="{{$requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                                 
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
                                  
                                    {{-- <div class="form-group row">
                                    <label for="transport" class="col-sm-2 col-form-label">Transport Cost</label>
                                    <div class="col-sm-4">
                                    <input type="number" class="form-control" value= "{{$requisition->transport_cost}}" id="transport_cost" name="transport_cost" readonly  required>
                                    </div>
                                  
                                    <div class="col-sm-4">
                                    
                                    </div>
                                    </div> --}}
                                    @endif
        
        
                           
                                
                                
                           <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Purchase Order#</label>
                        <div class="col-sm-4">
                        <input type="input" class="form-control" id ='purchase_order_no' name="purchase_order_no" value=""required>
                          </div>
                          <label for="institute" class="col-sm-2 col-form-label">Requisition no.</label>
                          <div class="col-sm-4">
                          <input type="input" class="form-control" name="requisition_no" value="{{$requisition->requisition_no}}" readonly>
                            </div>
                          </div>

                          <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Comments</label>
                        <div class="col-sm-4"> 
                        <textarea class="form-control" name ="comments" id="comments" value="" rows="3" placeholder="Enter ..."></textarea>
                          </div>

                          @if($requisition->internalrequisition->comment->isNotEmpty())
                         
                            <label for="" class="col-sm-2 col-form-label">Refusal Comments</label>
                            <div class="col-sm-4"> 
                            <textarea class="form-control" name ="" id="" value="" rows="3" disabled >
                              @foreach($requisition->internalrequisition->comment as $comment)
                                    {{$comment->user->abbrName()}}: {{$comment->comment}}
                            @endforeach
                            </textarea>

                     
                              </div>
                             

                              @endif


                          </div>

                        <div class="row">

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





                        <div class="col-sm-6">
                          <label for="exampleInputFile">Attached Documents</label>
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
                  <td> <button class="btn btn-danger" onclick="" type="button" disabled >Remove</button></td>
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
            </div>

                
            </br>
         

          <div class="form-group row">
                      <div class="col-sm-6">
                        @if(isset($requisition->internalrequisition->approve_internal_requisition))
                        Approve IRF by: <span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
                      @else
                      Approve IRF by:</br>
                      Date:</br>
                      @endif
                      Budget Approve by: <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->user->abbrName()}} </span></br>
                      Date:  <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->created_at}}</span><br>
                        Accepted by: <span class='badge badge-success'>{{$requisition->check->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->check->created_at}}</span></br>
                      </div>
                      <div class="col-sm-6">
                       
                        @if(isset($requisition->approve))
                        @if($requisition->approve_count === 1)
                        Approve Requisition by:  <span class='badge badge-success'>{{$requisition->approve->user->abbrName()}}</span></br>
                      Date:<span class='badge badge-success'>{{$requisition->approve->created_at}}</span></br>
                        @else
                        @foreach($requisition->approve->where('requisition_id',$requisition->id)->get() as $key=> $approve)

                        {{$approve->user->role->name}} : <span class='badge badge-success'> {{$approve->user->abbrName()}}</span></br>
                         Date:<span class='badge badge-success'>{{$approve->created_at}}</span></br>
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
           
            <!-- /.card -->
            
          
         
        

<div id="get_name"></div>
      <div class="row">
                        <div class="col-10">
                     
                        <button type="submit" id='btnSubmit'  class="btn btn-outline-primary float-right btn-lg">Submit</button>
                        </div>
      </div>
                        <br>

    </form>

    {{-- modal start --}}
            <div class="modal fade" id="modal-lg">
              <div class="modal-dialog modal-m">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Supervisor Override</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                  </div>
                  <div class="modal-body">
                     <div class="card-body">
                      <form  id='form-refuse' class="form-horizontal" method="POST" autocomplete="off" action="/verify_password" enctype="multipart/form-data" >
                        @csrf 
                          <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-6">
                        <input type="email" name ="email" class="form-control" value="" required>
                          </div>
                          </div>
                          <div class="form-group row">
                        <label for="trn" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-6">
                        <input type="password" name ="password" class="form-control" value="" required>
                        </div>
                        </div>

                     
                    

            
                  
                  </div>
                 
                    <button type="button" class="btn btn-default btn-lg " data-dismiss="modal">Close</button>
                    <button type="submit" id="verify" class="btn btn-outline-primary float-right btn-lg" id="verify" onclick="">Send</button>
                   </form>
                 
                </div>
          
              </div>
            
            {{-- modal end --}}
                      
                      </div><!-- /.card-body -->
                      

      
                      </div><!-- /.container-fluid -->
        </div>
@endsection


@include('partials.datatable-scripts')

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@push('scripts')
{{-- <script src="/plugins/datatables/dataTables.select.min.js"></script> --}}
{{-- <script src="/js/dataTables.select.min.js"></script> --}}

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


// $('#tax ,#freight ,#trade_discount ,#miscellaneous, #subtotal' ).on('input',function(){
// var tax = parseInt($('#tax').val());
// var freight = parseInt($('#freight').val());
// var trade_discount = parseInt($('#trade_discount').val());
// var miscellaneous = parseInt($('#miscellaneous').val());
// var subtotal =parseInt($('#subtotal').val()); 
// console.log(subtotal);
// $('#order_total').val((subtotal +tax + freight + trade_discount + miscellaneous  ? subtotal + tax + freight + trade_discount + miscellaneous : 0).toFixed(2));

// });

$(document).ready(function () {

$("#purchase_order_form").submit(function (e) {

    //stop submitting the form to see the disabled button effect
   // e.preventDefault();

    //disable the submit button
    $("#btnSubmit").attr("disabled", true);

    

    return true;

});
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


 $('#btnSubmi').click(function(e){
  
    var password = $('#password').val();
    var email = $('#email').val();
    var certifier_id =  {!! json_encode($requisition->check->user->id, JSON_HEX_TAG) !!};
    var user_id = {!! json_encode($requisition->check->user->id, JSON_HEX_TAG) !!};
   
    if (certifier_id = user_id){
         console.log(password);
        $("#modal-lg").modal('show');
           e.preventDefault();
       $('#verify').click(function(){  
      $.post( {!! json_encode(url('/')) !!} + "/verify_password",{ _method: "Post",data:{email:email,password:password},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Your password is correct",
                "success").then(esc => {
                  if(esc){
                    location.reload();
                  }
                });
              }else{
                swal(
                  "Oops! Something went wrong.",
                  "Email or password is incorrect.",
                  "error");
                  $("#purchase_order_form").submit(function(e){
                  e.preventDefault();
                   $("#btnSubmit").attr("disabled", true);
                   });
                }
                 location.reload();
             
               
              });
       });
   

    }


  });
  


});


$(document).ready(function () {

var user_role_id = {!! json_encode(Auth::user()->role_id) !!};
var user_int_id = {!! json_encode(Auth::user()->institution_id) !!};
var count = {!! json_encode($count) !!};
const int = [1,5,8,10];
var requisition_int_id = {!! json_encode($requisition->institution_id) !!};
if( count < 2 && jQuery.inArray(requisition_int_id,int) ===-1){
  $("#btnSubmit").attr("disabled", true); 
  swal(
  'Alert',
  'Waiting for second approval.',
  'warning'
        )
}


});
</script>

@endpush

