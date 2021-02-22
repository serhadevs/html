




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
              <textarea  readonly class="form-control" name="comments" rows="3" placeholder="{{$internalRequisition->comments}}"></textarea>
              </div>
            </div>
            
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
                        <button type="button"   class="btn btn-warning">Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"  onclick="Approve('{{$internalRequisition->id}}');">Approve</button></br>
                       

                        @endif
                      </div> 
                       
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

  
</script>

@endpush

