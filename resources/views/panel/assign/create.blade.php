




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
            <h1> Assign Internal Requisition</h1>
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
                          Budget activity: {{$internalRequisition->budget_approve}}    </br>
                          Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                          Estimated Cost: {{$internalRequisition->estimated_cost}}</br>
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Phone: {{$internalRequisition->phone}}</br>
                        Email: {{$internalRequisition->email}}</br>
                        Procurement Type: {{$internalRequisition->requisition_type->name}}</br>
                        Priority: {{$internalRequisition->priority}}</br>
                        Requisition no : {{$internalRequisition->requisition_no}}</br>
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
                <td>{{$stock->unit_of_measurement_id}}</td>
                <td>{{$stock->unit_cost}}</td>
                <td> {{$stock->estimated_total ? '$'.number_format($stock->estimated_total,2) : '$'.number_format($stock->quantity * $stock->unit_cost,2) }}</td>
            
       
              
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
     <td><input  readonly  name="sales_tax" id="sales_tax" type='text' size="10" value="${{($internalRequisition->stocks->sum('estimated_total') * .15) }}" style='border:none;outline:none;background: transparent;'></td>
  </tr>
   <tr>
    <td  size="5">Grand Total</td>
     <td><input id='grandtotal' readonly type='text' value="${{$internalRequisition->estimated_cost}}" size="10" style='border:none;outline:none;background: transparent;' name="grandtotal"></td>
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
              <textarea  readonly class="form-control" name="comments" rows="3" placeholder="">{{$internalRequisition->comments}}</textarea>
              </div>
            </div>



            @if($internalRequisition->comment->isNotEmpty())
            <div class="col-sm-6">
              <!-- textarea -->
              <div class="form-group">
                <label>Refusal Comments</label>
<textarea class="form-control" rows="3" disabled>
                  @foreach($internalRequisition->comment as $comment)
{{$comment->user->abbrName()}}: {{$comment->comment}}
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
                       
                        {{-- <div class="col-sm-5">
                        Approve Internal Requisition by: <span class='badge badge-success'></span>
                        </div> --}}
                        <div class="col-sm-5">
                        
                        Approve IRF: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->firstname[0]}}. {{$internalRequisition->approve_internal_requisition->user->lastname}} </span></br>
                        Date: {{$internalRequisition->approve_internal_requisition->created_at}}
                  
                        </div>
                        <div class="col-sm-5">
                        Budget Officer’s Name: <span class='badge badge-success'>{{$internalRequisition->budget_commitment->user->firstname[0]}}. {{$internalRequisition->budget_commitment->user->lastname}} </span><br>
                        Date:  {{$internalRequisition->budget_commitment->created_at}}</br>
                        Budget Manager: <span class='badge badge-success'>{{$internalRequisition->approve_budget->user->abbrName()}} </span><br>
                        Date:  {{$internalRequisition->approve_budget->created_at}}
                           
                        </div>

                        <form class="form-horizontal" id="assign_form" method="Post" autocomplete="off" action="/assign_requisition" enctype="multipart/form-data">
                        <label for="date-of-last" class="col-sm-5 col-form-label">Assign procurement Officer</label>
                        <div class="col-sm-5">
                  
                          @csrf
                          <input type="hidden" class="form-control"  value="{{$internalRequisition->id}}"name='requisition_id' id="requisition_id" readonly>
                         <select type="input" class="form-control" name="user_id" id="user_id" required>
                          <option value="">Select Officer</option>
                          @foreach($users as $user)
                         <option value="{{$user->id}}">{{$user->firstname[0]}}. {{$user->lastname}}</option>
                          @endforeach
                          
                         </select>  
                         
                        </div>
                 
                      </div>

      </div>
                      
                  </div>

     
      
          
                       
                        
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                     
                         
                        <button type="submit"  id="#btnSubmit"  class="btn btn-block btn-outline-primary  btn-lg" >Submit</button></br>
                        
                      </div> 
                       
                        </div>
                      </br>

                    </form>



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

function Assign(internal_requisition_id){
   
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
          $.post( {!! json_encode(url('/')) !!} + "/approve-internal-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
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

  
$(document).ready(function () {

$("#assign_form").submit(function (e) {

    //stop submitting the form to see the disabled button effect
   // e.preventDefault();

    //disable the submit button
    $("#btnSubmit").attr("disabled", true);

    

    return true;

});
});


</script>

@endpush

