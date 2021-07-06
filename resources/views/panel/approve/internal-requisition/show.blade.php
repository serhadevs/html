




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
                          Departmentent: {{$internalRequisition->department->name}} </br>
                          Budget officer approved: {{$internalRequisition->budget_approve}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                          Estimated Cost: {{$internalRequisition->estimated_cost}}</br>
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
                <th class="text-center">Part Number</th>


              
                
              </tr>
            </thead>
            <tbody>
               @foreach($internalRequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->unit_of_measurement_id}}</td>
                <td>{{$stock->unit_cost}}</td>
                <td>{{$stock->part_number}}</td>
            
       
              
              </tr>
               
           @endforeach
         
            </tbody>
          </table>
    
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
            {{$comment->user->abbrName()}}  : {{$comment->comment}}
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
                       
                        <div class="col-sm-5">
                        Certify by: <span class='badge badge-success'>{{$internalRequisition->certified_internal_requisition->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalRequisition->certified_internal_requisition->created_at}}</span>
                        </div> 
                        <div class="col-sm-5">
                         @if($internalRequisition->approve_internal_requisition)
                        Approve by: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->firstname[0]}}. {{$internalRequisition->approve_internal_requisition->user->lastname}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->created_at}}</span>
                        @else
                          Approve  by: <span class='badge badge-success'></span>
                          @endif
                        </div>
                      </div>

      </div>
                      
                  </div>

     
      
          
                       
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                          @if($internalRequisition->approve_internal_requisition)
                          <button type="button"   class="btn btn-warning" disabled>Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"   disabled>Approve</button></br>
                        @else
                        <button type="button"   class="btn btn-warning"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        @if(in_array(auth()->user()->role_id,[1,2,10,11,12]))
                        <button type="button"   class="btn btn-primary float-right"  onclick="Approve('{{$internalRequisition->id}}');">Approve</button></br>
                       @else
                       <button type="button"   class="btn btn-primary float-right"   disabled>Approve</button></br>
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
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-primary float-right" id="post" onclick="Refuse('{{$internalRequisition->id}}');">Send</button>
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
                "Internal Requisition was approve and will shortly be forwarded to budget commitment.",
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

