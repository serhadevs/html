




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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>  Certify Requisition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-10">
            <div class="card">
              {{-- <div class="card-header">
                  
                  <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a>
                <h3 class="card-title">A list of all procurement requisition </h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p><br>
                        </div>

                      Requester:  <b>{{$requisition->internalrequisition->user->firstname[0]}}. {{$requisition->internalrequisition->user->lastname}}</b>

                        <p><br>Institution: {{$requisition->institution->name}}</br>
                          Departmentent: {{$requisition->department->name}} </br>
                          {{-- Cost Centre: {{$requisition[0]->cost_centre}}    </br> --}}
                          Date Ordered: {{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}
                         
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Requisition Type: {{$requisition->internalrequisition->requisition_type->name}}</br>  
                        Cost Centre: {{$requisition->cost_centre}}</br>
                        Description: {{$requisition->description}}</br>
                        TCC Number: {{$requisition->tcc}}</br>
                        TCC Expired: {{$requisition->tcc_expired_date}}</br>
                        Contract Sum: {{$requisition->internalrequisition->currency->abbr}} ${{number_format($requisition->contract_sum,2)}}</br>
                        Requisition no.: {{$requisition->internalrequisition->requisition_no}}</br>
                        @if($requisition->advertisement_method)
                        Tendering Opening: {{Carbon\Carbon::parse($requisition->tender_opening)->format('Y-M-d')}}</br>
                        Tender Period From: {{Carbon\Carbon::parse($requisition->tender_from)->format('Y-M-d')}}</br>
                        Tender Period To: {{Carbon\Carbon::parse($requisition->tender_to)->format('Y-M-d')}}</br>
                        Tender Bond Request: {{$requisition->tender_bond}}</br>
                        Number of days: {{$requisition->number_days}}</br>
                        @endif

                     

                        </div>
                        
                        <div class="col-sm-6">
                        Procurement Method: {{$requisition->procurement_method->name}}</br>
                        Commitment: {{$requisition->commitment_no}}</br>
                        Category: {{$requisition->category->name}} </br>
                        Supplier Trn: {{$requisition->supplier->trn}}</br>
                        Estimate Cost: {{$requisition->internalrequisition->currency->abbr}}  ${{number_format($requisition->internalrequisition->estimated_cost,2)}} </br>
                        Cost Variance: {{$requisition->cost_variance}} </br>
                        @if($requisition->advertisement_method)
                        Method of Advertisement: {{$requisition->advertisement_method->name}}</br>
                        Number Bid Request: {{$requisition->bid_request}}</br>
                        Number Bid Received: {{$requisition->bid_received}}</br>
                        Bid validity: {{$requisition->validity}}</br>
                        Expiration Date: {{Carbon\Carbon::parse($requisition->expiration_date)->format('Y-M-d')}}</br>
                        Transport_cost: ${{number_format($requisition->transport_cost,2)}}</br>
                        @endif
                        


                        
                       
                        

                        </div>
                        </div>
                        </p> 
                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                      
                    
                     <h3 class="card-title">Recommended Supplier</h3>
                        <input type="text" class="form-control" value="{{$requisition->supplier->name}}" readonly >
                        </div>
                 
                     
                        <div class="col-sm-6">
                  
                     
                        <h3 class="card-title"> Supplier Address</h3>
                        <input type="text" class="form-control" id="inputEmail3" value="{{$requisition->supplier->address}}" readonly>
                   
                        </div>
                      
                        </div>
                        </p> 
                          
                <div class="col-sm-12">
                {{-- <div class="card" > --}}
                {{-- <div class="card-body"> --}}
                {{-- <h3 class="card-header text-center font-weight-bold text-uppercase py-4">requisitions</h3> --}}
              
    
          <table id="table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                {{-- <th class="text-center">Unit Cost</th> --}}
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
                <td>{{$stock->unit_of_measurement_id}}</td>
                {{-- <td>{{$stock->unit_cost}}</td> --}}
                <td>{{$stock->actual_cost ? '$'.number_format($stock->actual_cost,2) : '$'.number_format($stock->quantity * $stock->actual_cost,2)}}</td>
                <td>${{number_format($stock->actual_total,2)}}</td>

              
              </tr>
               
           @endforeach
            
            </tbody>
          </table>
     
      {{-- </div> --}}
    {{-- </div> --}}
    <!-- Editable table -->
                      
    </div>

     @if($requisition->internalrequisition->stocks[0]->actual_cost !=null)
    <div class="row">
      <div class="col-sm-8">
             
      </div>

                         
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  style='width:1px;'>Sub Total</td>
    <td style='width:20px;'>${{number_format($requisition->internalrequisition->stocks->sum('actual_total'),2) }}</td>
  </tr>
   <tr>
    <td style='width:20px;'>Sales Tax (15.0%)</td>
    @if($requisition->tax_confirmed===0)
     <td style='width:42px;'>${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * 0,2) }}</td>
     @else
     <td style='width:42px;'>${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * .15,2) }}</td>
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
     <td style='width:20px;'>${{number_format($requisition->contract_sum,2)}}</td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>

      @endif


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
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                    <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled >Remove</button></td>
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
              <br>
              <br>
               </div> 
                        <div class="form-group row">
                        <div class="col-sm-6">
                          
                        </div>
                        <div class="col-sm-6">
                                            
                        </div>
                      
                        </div>
                          <div class="form-group row">
                      <div class="col-sm-6">
                        Approve IRF by: <span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->user->abbrName()}}</span></br>
                        Date:<span class='badge badge-success'>{{$requisition->internalrequisition->approve_internal_requisition->created_at}}</span></br>
                        @if($requisition->check)
                          @if($requisition->check->is_checked===1)
                          @foreach($requisition->check->where('requisition_id',$requisition->id)->get() as $key => $check)
                          {{$check->user->institution_id == 1? 'RO':'Institute'}} accepted by: <span class='badge badge-success'> {{$check->user->abbrName()}}</span></br>
                          Date:<span class='badge badge-success'>{{$check->created_at}}</span></br>
                          @endforeach
                         
                          @else
                          Accepted by: 
                          @endif
                          @endif
                          Budget Approve by: <span class='badge badge-success'>{{$requisition->internalrequisition->approve_budget->user->abbrName()}} </span></br>
                          Date:  <span class='badge badge-success'>{{$requisition->internalrequisition->approve_budget->created_at}}</span></br>
                          
                          
                      </div>
                      <div class="col-sm-6">
                        
                              Budget Commitment by: <span class='badge badge-success'>{{$requisition->internalrequisition->budget_commitment->user->abbrName()}} </span></br>
                              Date:  <span class='badge badge-success'>{{$requisition->internalrequisition->budget_commitment->created_at}}</span></br>
                              
                              @if(isset($requisition->approve))
                              @if($requisition->approve_count === 2)
                              @foreach($requisition->approve->where('requisition_id',$requisition->id)->get() as $key=> $approve)
                              {{($key ===0) ? ('CEO') : (($key ===1) ? ('Parish Manager') : ('Director of Procurement'))}} : <span class='badge badge-success'> {{$approve->user->abbrName()}}</span></br>
                               Date:<span class='badge badge-success'>{{$approve->created_at}}</span></br>
                              @endforeach
                              @else
                               Approve Requisition: <span class='badge badge-success'> {{$requisition->approve->user->abbrName()}}</span></br>
                               Date:<span class='badge badge-success'>{{$requisition->approve->created_at}}</span></br>
                              @endif

                             @endif
                           
                 
                      </div>
                    
                      </div> 
                        
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
                    {{-- {{$requisition->store_approves->where('requisition_id',$requisition->id)->count()}} --}}
                        <div class="col-10">
                           @if($requisition->check) 
                           @if($requisition->check->where('requisition_id',$requisition->id)->count()===1 AND $requisition->approve_count >=1 AND $requisition->institution_id != 1)
                           <button type="button"   class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                           <button type="button"   class="btn btn-outline-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');" >Accept</button></br>
                           
                          @else
                          
                          <button type="button"   class="btn btn-warning btn-lg"  data-toggle="modal" data-target="#modal-lg" disabled>Refuse</button>
                           <button type="button"   class="btn btn-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');" disabled>Accept</button></br>
                          @endif
                      
                      
                      
                          @else
                        <button type="button"   class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        <button type="button"   class="btn btn-outline-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');" >Accept</button></br>
                          @endif
                      </div>
                        </br>

       


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
                                  <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
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
                      </br>
                      </div>
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

function Accept(requisitionId){
   swal({
        title: "Are you sure you want to accept the selected applications?",
        text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "success",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,checked:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was accepted and will shortly be forwarded for approval.",
                "success").then(esc => {
                  if(esc){
                    location.href="/check-purchase";
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


// function RefuseRequisition(requisitionId) {
   
//         $(this.form).submit();
//         console.log('submit');
    
//         $('#modal-lg').modal('hide');
//         // e.preventDefault();
//         $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,refuse:1,check:0}
//                // data: id,
//                 // success: function(data){
//                 //     alert("Successfully submitted.");
//                 //     location.href='/check-purchase';
//                 // }
              
//               });
//               alert("Successfully submitted.");
//               location.href='/check-purchase';
//               console.log(data);

          
            
//     }




    // $(function () {
    // $('body').on('click', '#post', function (e) {
    //     $(this.form).submit();
    //     console.log('submit');
    
    //     $('#modal-lg').modal('hide');
    //     e.preventDefault();
    //         $.ajax({
    //             url: '/check-purchase',
    //             type: 'POST',
    //             // data:{requisitionId:requisitionId}
    //             data: $("#form-refuse").serialize(),
    //             // success: function(data){
    //             //     alert("Successfully submitted.");
    //             //     location.href='/check-purchase';
    //             // }
              
    //           });
    //           alert("Successfully submitted.");
    //           location.href='/check-purchase';
    //           console.log(data);

    //          });
            
    // });

function Refuse(requisitionId){
  var comment = $('#comment').val();
  console.log(comment);
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
          $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,checked:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was refuse and will send an email to the requester.",
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
                location.href='/check-purchase';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}

  


</script>

@endpush

