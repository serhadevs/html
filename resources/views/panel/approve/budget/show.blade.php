




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
            <h1> Budget Approve</h1>
          </div>
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          {{-- </div> --}} 
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-10">
            <div class="card">
              <div class="card-body">
                  
              <a href="/print_pdf/{{$internalRequisition->id}}" class="btn btn-outline-danger float-right btn-lg">Print PDF</a>
              
              </div> 
              <!-- /.card-header -->
              <div class="card-body">
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p><br>
                        </div>

                          Requester:  <b>{{$internalRequisition->user->abbrName()}}</b>

                          <p><br>Institution: {{$internalRequisition->institution->name}}</br>
                          Department: {{$internalRequisition->department->name}} </br>
                          Budget activity: {{$internalRequisition->budget_approve}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                          Estimated Cost:{{$internalRequisition->currency->abbr}} ${{number_format($internalRequisition->estimated_cost)}}</br>
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Phone: {{$internalRequisition->phone}}</br>
                        Email: {{$internalRequisition->email}}</br>
                        Procurement Type: {{$internalRequisition->requisition_type->name}}</br>
                        Priority:{{$internalRequisition->priority}}</br>
                        Requisition no: {{$internalRequisition->requisition_no}}</br>
                        Commitment : {{$internalRequisition->budget_commitment->commitment_no}}</br>
                        Accounting : {{$internalRequisition->budget_commitment->account_code}}
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
                <td>{{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2)}}</td>
            
       
              
              </tr>
               
           @endforeach
         
            </tbody>
          </table>
             @if(isset($internalRequisition->stocks))
           @if($internalRequisition->stocks[0]->estimated_total != null)
             <div class="row">
      

                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-center">
  <tr >
    <td>Sub Total</td>
    <td>${{number_format($internalRequisition->stocks->sum('estimated_total'),2)}}</td>
  </tr>
   <tr>
    <td>Sales Tax (15.0%)</td>
    @if($internalRequisition->tax_confirmed===0)

     <td>${{number_format($internalRequisition->stocks->sum('estimated_total') * 0,2) }}</td>
     @else
     <td>${{number_format($internalRequisition->stocks->sum('estimated_total') * .15,2) }}</td>
     @endif
  </tr>
   <tr>
    <td>Grand Total</td>
     <td>${{$internalRequisition->estimated_cost}}</td>
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>
      @endif
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
              <textarea  readonly class="form-control" name="comments" rows="3" >{{$internalRequisition->comments}}</textarea>
              </div>
            </div>


            @if($internalRequisition->comment->isNotEmpty())
                        <div class="col-sm-6">
                          <!-- textarea -->
                          <div class="form-group">
                    <label>Refusal Comments</label>
                    <textarea  class="form-control" rows="3" disabled>
@foreach($internalRequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}}
@endforeach
                    </textarea>
                          </div>
                        </div>
                        @endif
                        
            
          </div>        
    </div>




            
                <br>
          <br>
        

                    
                

                        <div class="col-12">
                        <div class="form-group row">
                         
                          <div class="col-sm-6">
                            @if($internalRequisition->approve_internal_requisition)
                            Approved by: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->abbrName()}} </span></br>
                            Date:  <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->created_at}}</span></br>
                            @else
                              Approve  by: <span class='badge badge-success'></span>
                              @endif

                              Budget Commitment by: <span class='badge badge-success'>{{$internalRequisition->budget_commitment->user->abbrName()}} </span></br>
                              Date:  <span class='badge badge-success'>{{$internalRequisition->budget_commitment->created_at}}</span>

                          </div>
  
                          
                          <div class="col-sm-6">
                        @if($internalRequisition->approve_budget)
                        Budget Approve by: <span class='badge badge-success'>{{$internalRequisition->approve_budget->user->abbrName()}} </span></br>
                        Date:  <span class='badge badge-success'>{{$internalRequisition->approve_budget->created_at}}</span>
                        @else
                        Budget Approve by: <span class='badge badge-success'></span>
                          @endif
                          </div>
                        </div>
                      </div>





                     

      </div>
                      
                  </div>

     
      
          
                       
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                          @if($internalRequisition->approve_budget)
                          <button type="button"   class="btn btn-warning btn-lg" disabled>Refuse</button>
                        <button type="button"   class="btn btn-primary float-right btn-lg"   disabled>Approve</button></br>
                        @else
                        <button type="button"   class="btn btn-outline-warning btn-lg"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        <button type="button"   class="btn btn-outline-primary float-right btn-lg"  onclick="Approve('{{$internalRequisition->id}}');">Approve</button></br>
                       

                        @endif
                      </div> 
                       
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
                      <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/approve-budget-requisition" >
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
                    <button type="button" class="btn btn-default btn-lg " data-dismiss="modal">Close</button>
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
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 

 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
 <script src=" https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-budget-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id,permission:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Internal Requisition Budget was approved. ",
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
  console.log(internal_requisition_id);
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-budget-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id,permission:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
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
                location.href='/approve-budget-requisition';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}


$(document).ready( function () {
    $('#table').DataTable({
         "scrollX": false,
         deferRender:true,
        //  select: true,
         "bFilter": false,
         "bPaginate": true,
         "bInfo": true,
          dom: 'Bfrtip',
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      
    });
    
} );








  
</script>


@endpush

