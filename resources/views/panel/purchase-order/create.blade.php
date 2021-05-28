




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

                <form class="form-horizontal" id='purchase_order_form' method="Post" autocomplete="off" action="/purchase-order" >
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
                                <label for="cost-centre" class="col-sm-2 col-form-label">Recommended </label>
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
                                <label for="date-of-last" class="col-sm-2 col-form-label">TRN</label>
                                <div class="col-sm-4">
                                 
                                 <input type="number" class="form-control" value="{{$requisition->trn}}" name='trn' readonly>
                                 
                                </div>
                                </div>
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">TCC Expired </label>
                               
                                <div class="col-sm-4">
                                <div class="input-group date" id="tcc_expired" data-target-input="nearest">
                                <input type="text" class="form-control datepicker-input" name='tcc_expired_date' value="{{$requisition->tcc_expired_date}}" data-target="#tcc_expired" readonly/>
                                <div class="input-group-append" data-target="#tcc_expired" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                </div>
                                
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Estimated Cost</label>
                                <div class="col-sm-4">
                                 
                                 <input type="number" class="form-control" value="{{$requisition->internalrequisition->estimated_cost}}" id= 'estimated_cost' name='estimated_cost' readonly>
                                 
                                </div>
                                </div>
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Contract Sum </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$requisition->contract_sum}}" id="contract_sum" name='contract_sum'readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Cost Variance</label>
                                <div class="col-sm-4">
                                 
                                 <input type="number" class="form-control" value="{{$requisition->cost_variance}}" id='cost_variance' name='cost_variance' readonly>
                                 
                                </div>
                                </div>
        
        
                           
                                
                                 {{-- <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Date Required</label>
                                <div class="col-sm-4">
                                 
                               <div class="input-group date" id="date_require" data-target-input="nearest">
                                <input type="text" class="form-control datepicker-input" name='date_require' value='{{$requisition->date_require}}' data-target="#date_require" readonly/>
                                <div class="input-group-append" data-target="#date_require" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                 </div> 
                               </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Date Last Order</label>
                                <div class="col-sm-4">
                                  <div class="input-group date" id="date_last_ordered" data-target-input="nearest">
                                <input type="text" class="form-control datepicker-input" name='date_last_ordered' value='{{$requisition->date_last_ordered}}' data-target="#date_last_ordered" readonly/>
                                <div class="input-group-append" data-target="#date_last_ordered" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                 </div>
                                </div>
                                </div> --}}
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
              </table>
            {{-- </form> --}}
            </div>
             </div> 

                
            </br>
         

          <div class="form-group row">
                      <div class="col-sm-6">
                        Approve IRF by: <span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
                      
                        Accepted by: <span class='badge badge-success'>{{$requisition->check->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->check->created_at}}</span></br>
                      </div>
                      <div class="col-sm-6">
                        
                   
                        Approve Requisition by:  <span class='badge badge-success'>{{$requisition->approve->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->approve->created_at}}</span></br>
                
                  
                 
                      </div>
                    
                      </div> 
             
                     </div>
                    </div>
                  </div>
           
            <!-- /.card -->
            
            
          
         
        

<div id="get_name"></div>
      <div class="row">
                        <div class="col-10">
                     
                        <button type="submit" id='btnSubmit'  class="btn btn-primary float-right">Submit</button>
                        </div>
      </div>
                        <br>

    </form>
                      
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


</script>

@endpush

