




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
            <h1> Approve Internal Requisition</h1>
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

                          Requester:  <b>{{$internalRequisition->user->firstname[0]}}. {{$internalRequisition->user->lastname}}</b>

                          <p><br>Institution: {{$internalRequisition->institution->name}}</br>
                          Department: {{$internalRequisition->department->name}} </br>
                          Budget activity: {{$internalRequisition->budget_approve}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                          Estimated Cost: ${{number_format($internalRequisition->estimated_cost,2)}} {{$internalRequisition->currency->abbr}}</br>
                          Requisition no: {{$internalRequisition->requisition_no}}</br
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Phone: {{$internalRequisition->phone}}</br>
                        Email: {{$internalRequisition->email}}</br>
                        Procurement Type: {{$internalRequisition->requisition_type->name}}</br>
                        Priority:{{$internalRequisition->priority}}</br>
                        </div>
                        
                        <div class="col-sm-6">
                        {{-- Procurement Method: {{$internalRequisition->procurement_method->name}}</br>
                        Commitment: {{$internalRequisition->commitment_no}}</br>
                        Category: {{$internalRequisition->category->name}} </br>
                        TRN: {{$internalRequisition->trn}}</br>
                        Estimate Cost: {{$internalRequisition->estimated_cost}} </br>
                        Cost Variance: {{$internalRequisition->cost_variance}} </br>
                        Date Last Order: {{$internalRequisition->date_last_ordered}} </br>
                         --}}

                        </div>
                        </div>
                        </p> 
                        <p>
                       
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
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Total</th>


              
                
              </tr>
            </thead>
            <tbody>
               @foreach($internalRequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->unit_of_measurement->name}}</td>
                <td>${{number_format($stock->unit_cost,2)}}</td>
                <td>${{number_format($stock->estimated_total,2) ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2)}}</td>
            
       
              
              </tr>
               
           @endforeach
         
            </tbody>
          </table>
           @if($internalRequisition->stocks[0]->estimated_total != null)
             <div class="row">
      <div class="col-sm-8">
             
      </div>

                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    <td  size="5">Sub Total</td>
    <td><input id='subtotal' readonly  name="subtotal" type='text' size="10" value="${{$internalRequisition->stocks->sum('estimated_total')}}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td size="5">Sales Tax (15.0%)</td>
    @if($internalRequisition->tax_confirmed ===0)
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internalRequisition->stocks->sum('estimated_total') * 0) }}" style='border:none;outline:none;background: transparent;'></td>
     @else
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internalRequisition->stocks->sum('estimated_total') * .15) }}" style='border:none;outline:none;background: transparent;'></td>
     @endif
  </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{number_format($internalRequisition->estimated_cost,2)}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
      @endif

          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>General Description</label>
              <textarea  readonly class="form-control" name="comments" rows="3">{{$internalRequisition->description}}</textarea>
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
                    @foreach($internalRequisition->attached as $file)
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
    
          <div class="row">
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Comments/Justification</label>
              <textarea  readonly class="form-control" name="comments" rows="3">{{$internalRequisition->comments}}</textarea>
              </div>
            </div>

            @if($internalRequisition->comment->isNotEmpty())
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Refusal Comments</label>
              <textarea class="form-control" rows="3" disabled   >
@foreach($internalRequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}} 
{{Carbon\Carbon::parse($comment->created_at)->format('d/M/Y')}}
@endforeach
              </textarea>
              </div>
            </div>
            @endif
            
          </div>        
    </div>


 <div class="form-group row">

            
                <br>
          <br>
        

                        <div class="col-10">
                         @if(isset($internalRequisition->certified_internal_requisition))
                         @if($internalRequisition->certified_internal_requisition->is_granted===1)
                        <div class="col-sm-5">
                       
                        Certify by: <span class='badge badge-success'>{{$internalRequisition->certified_internal_requisition->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalRequisition->certified_internal_requisition->created_at}}</span>
                        </div> 
                        @endif
                        @endif
                        <div class="col-sm-5">
                         @if($internalRequisition->approve_internal_requisition)
                         @if($internalRequisition->approve_internal_requisition->is_granted===1)
                        Approve by: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->firstname[0]}}. {{$internalRequisition->approve_internal_requisition->user->lastname}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->created_at}}</span>
                        @else
                          Approve  by: <span class='badge badge-success'></span>
                          @endif
                          @endif
                        </div>
                      </div>

                      {{-- @if(isset($internalRequisition->approve_internal_requisition->audits()->latest()->first()->old_values['is_granted']))
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <div class="info-box-content bg-gray">
                            Update By: {{$internalRequisition->audits()->latest()->first()->user->lastname}} </br>
                            <br>
                            Old Estimated Cost: ${{number_format($internalRequisition->audits()->latest()->first()->old_values['estimated_cost'],2)}}  <br>
                            <br>
                          </div>
                        </div>
                      </div>
                      @endif --}}

      </div>                
      </div>

     
      
          
                       
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                          @if($internalRequisition->approve_internal_requisition)
                          <button type="button"   class="btn btn-warning btn-lg" disabled>Refuse</button>
                        <button type="button"   class="btn btn-primary float-right btn-lg"   disabled>Approve</button></br>
                        @else
                        <button type="button"   class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        @if(in_array(auth()->user()->role_id,[1,2,10,11,12,15]) OR in_array(2,auth()->user()->userRoles_Id()->toArray()))
                        <button type="button"   class="btn btn-outline-primary float-right btn-lg"  onclick="Approve('{{$internalRequisition->id}}');">Approve</button></br>
                       @else
                       <button type="button"   class="btn btn-primary float-right btn-lg"   disabled>Approve</button></br>
                       @endif

                        @endif
                      </div>  
                       
                        </div>
                      </br>

                       {{-- //modal  --}}

             <div class="modal fade" id="modal-lg">
              <div class="modal-dialog modal-m">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Refuse Internal Requisition</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <div class="card-body">
                      <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/approve-internal-requisition" >
                        @csrf 
                         <div class="form-group row">
                        <label for="cost-centre" class="col-m-4 col-form-label">Comments</label>
                        <div class="col-m-8">
                            <textarea type="text" style="width:400px; height:200px;" value="{{Request::old('comment')}}" id="comment" name='comment'></textarea>
                        </div>
                        <input type="hidden" name='requisition_id' id="requisition_id" value="{{$internalRequisition->id}}"> 
                        </div>


                     
                    </form>

            
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-outline-primary float-right btn-lg" id="post" onclick="Refuse('{{$internalRequisition->id}}');">Send</button>
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

function Approve(internal_requisition_id){
   
        swal({
        title: "Are you sure you want to approve the selected internal requisition form?",
        text: "Tip: Always ensure that you review each internal requisition form thoroughly before approval.",
        icon: "warning",
        buttons: [ 
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          console.log("approve");
          $.post( {!! json_encode(url('/')) !!} + "/approve-internal-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id,permission:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Internal Requisition was approved and will shortly be forwarded for budget commitment.",
                "success").then(esc => {
                  if(esc){
                    location.href="/approve-internal-requisition";
                  }
                });
              }else{
                swal(
                  "Oops! Something went wrong.",
                  "Application(s) were NOT approved",
                  "error");
                }
              });
            }
       
        });
}

function Refuse(internal_requisition_id){
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-internal-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id,permission:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
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
                location.href='/approve-internal-requisition';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}

  
</script>

@endpush

