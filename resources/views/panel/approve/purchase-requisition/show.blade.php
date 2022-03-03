




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
            <h1> Approve Purchase Requisition</h1>
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

                      Requester:  <b>{{$requisition->internalrequisition->user-> abbrName()}}</b>

                        <p><br>Institution: {{$requisition->institution->name}}</br>
                          Departmentent: {{$requisition->department->name}} </br>
                          Cost Centre: {{$requisition->cost_centre}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($requisition->internalrequisition->created_at)->format('Y-M-d')}}
                         
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Requisition Type: {{$requisition->internalrequisition->requisition_type->name}}</br>  
                        Cost Centre: {{$requisition->cost_centre}}</br>
                        Description: {{$requisition->description}}</br>
                        TCC Number: {{$requisition->tcc}}</br>
                        PPC Number: {{$requisition->ppc}}</br>
                        Supplier Trn: {{$requisition->supplier->trn}}</br>
                        Contract Sum: {{$requisition->internalrequisition->currency->abbr}} ${{number_format($requisition->contract_sum,2)}}</br>
                        {{-- Date Required: {{$requisition->date_require}}</br> --}}
                        Requisition no: {{$requisition->requisition_no}} </br>
                        </div>
                        
                        <div class="col-sm-6">
                        Procurement Method: {{$requisition->procurement_method->name}}</br>
                        Commitment: {{$requisition->commitment_no}}</br>
                        Category: {{$requisition->category->name}} </br>
                        TCC Expired: {{$requisition->tcc_expired_date}}</br>
                        PPC Expired: {{$requisition->ppc_expired_date}}</br>
                        Estimated Cost: {{$requisition->internalrequisition->currency->abbr}} ${{number_format($requisition->internalrequisition->estimated_cost,2)}} </br>
                        Cost Variance: {{$requisition->cost_variance/100}}%</br>
                        Term: {{$requisition->delivery}} </br>
                       
                        

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
                          
                <div class="col-m-12">
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
                <td>{{$stock->unit_of_measurement->name}}</td>
                {{-- <td>{{$stock->unit_cost}}</td> --}}
                <td>{{$stock->actual_cost ? '$'.number_format($stock->actual_cost,2) : '$'.number_format($stock->quantity * $stock->actual_cost,2)}}</td>
                <td>${{number_format($stock->actual_total,2)}}</td>
               
              
              </tr>
               
           @endforeach
           {{-- <tr>
              <th>Grand Total</th> 
              <td></td> 
              <td></td> 
              <td></td> 
              <td></td>
              <td></td>
           <td>{{$requisition->total}}</td>  
          </tr>   --}}
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
    <td style='width:20px;'><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total'),2) }}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td style='width:20px;'>Sales Tax (15.0%)</td>
    @if($requisition->tax_confirmed ===0)
     <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * 0,2) }}" style='border:none;outline:none;background: transparent;'></td>
  @else
  <td style='width:42px;'><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * .15,2) }}" style='border:none;outline:none;background: transparent;'></td>
  @endif
    </tr>
   <tr>
    <td  style='width:20px;'>Grand Total</td>
     <td style='width:20px;'><input id='grandtotal' readonly type='text' value="${{number_format($requisition->contract_sum,2)}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
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
                  <td> <a class="btn btn-primary " href="{{ asset('/documents/'.$file->filename)}}">View</a></td>
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
               </div> 
               <br>
                <br>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        
                          Approved IR by: <span class='badge badge-success'>{{$requisition->internalRequisition->approve_internal_requisition->user->abbrName()}} </span></br>
                          Date:  <span class='badge badge-success'>{{$requisition->internalRequisition->approve_internal_requisition->created_at}}</span></br>
                       
                        Budget Commitment by: <span class='badge badge-success'>{{$requisition->internalRequisition->budget_commitment->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$requisition->internalRequisition->budget_commitment->created_at}}</span></br>
                        @if($requisition->approve)
                        Approve Requisition by: <span class='badge badge-success'> {{$requisition->approve->user->firstname[0]}}. {{$requisition->approve->user->lastname}} </span>
                       
                          @endif
                      </div>
                        <div class="col-sm-6">
                          Accepted by: <span class='badge badge-success'>{{$requisition->check->user->firstname[0]}}. {{$requisition->check->user->lastname}} </span></br>
                          Date:  <span class='badge badge-success'>{{$requisition->check->created_at}}</span></br>
                          Budget Approve by: <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->user->abbrName()}} </span></br>
                          Date:  <span class='badge badge-success'>{{$requisition->internalRequisition->approve_budget->created_at}}</span></br>
                        
                    
                   
                        </div>
                      
                        </div>
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-12">
                          @if($requisition->approve )
                        <button type="button"   class="btn btn-warning btn-lg" disabled>Refuse</button>
                        <button type="button"   class="btn btn-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');"disabled>Approve</button></br>
                      @else
                      @if(in_array(auth()->user()->institution,[1]))
                      <button type="button"   class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        <button type="button"   class="btn btn-outline-primary float-right btn-lg"  onclick="Accept('{{$requisition->id}}');" >Approve</button></br>
                         
                        
                        @endif

                      </div>
                        </br>
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-requisition",{ _method: "POST",data:{requisitionId:requisitionId,permission:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was approved and will shortly be forwarded for Purchase Order.",
                "success").then(esc => {
                  if(esc){
                   // location.reload();
                  location.href='/approve-requisition';
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-requisition",{ _method: "POST",data:{requisitionId:requisitionId,permission:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
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
                location.href='/approve-requisition';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}

  
</script>

@endpush

