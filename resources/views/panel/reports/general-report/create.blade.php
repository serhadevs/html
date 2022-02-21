

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')

<div class="card-body">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> 
            @if($module ===1)
         
            Internal Requisition
            @elseif ($module ===6)
            Requisition

            @else
            All Modules
            @endif

            Report </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  
                 
                <h3 class="btn btn float-right" class="card-title">A list of all Internal Requisition Form</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              @if($module === 1)
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    
                    <th>Status</th>
                    <th>Requisition No.</th>
                    <th>Requested by</th>
                    <th>Description</th>
                    <th>Estimated Cost</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>phone</th>
                    <th>Email</th>
                    <th>Request Required</th>
                    <th>Priority</th>
                    <th>Date Created</th>
                    {{-- <th>Date Approved</th> --}}
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($report as $internal_requisition)
                    <tr>
                  
                      @if(isset($internal_requisition->status))
                    <td> <span class ="badge bg-green">{{$internal_requisition->status->name}}</span></td>
                    @else
                    <td> <span class ="badge bg-warning">Error warning</span></td>
                    @endif
                    <td>{{$internal_requisition->requisition_no}}
                    <td>{{$internal_requisition->user->firstname[0]}}.{{$internal_requisition->user->lastname}}</td>
                    <td>{{$internal_requisition->description}}</td>
                    <td>{{$internal_requisition->estimated_cost}}</td>
                    
                    <td>{{$internal_requisition->department->name}}</td>
                    <td>{{$internal_requisition->institution->name}}</td>
                    <td>{{$internal_requisition->budget_approve}}</td>
                    <td>{{$internal_requisition->phone}}</td>
                    <td>{{$internal_requisition->email}}</td>
                    <td>{{$internal_requisition->requisition_type->name}}</td>
                    <td>{{$internal_requisition->priority}}</td>
                    <td>{{$internal_requisition->created_at}}</td>
                    </tr>
                    @endforeach
            
                 
                 
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> --}}
                </table>

                @elseif($module === 6)

               <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                   
                    <th>Requisition_no</th>
                    <th>Date Received in Procurement</th>
                    <th>Date returned to Institution</th>
                    <th>Date Re-submitted to Procurement</th>
                    <th>Requestor/Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    <th>Category</th>
                    <th>(Item/Description)</th>
                    <th>Contract Value</th>
                    <th>Date Sent to Procurement Officer</th>
                    <th>Date Sent for approval</th>
                    <th>Date Sent to Purchasing Officer</th>
                    <th>Date P.O Printed</th>
                    <th>P.O # / Contract #</th>
                    <th>Date submmited to Accounts for Pre-Payment</th>
                    <th>Date P.O Sent to Institution</th>
                    <th>Date document returned to institution</th>
                    <th>Date Final Invoice Received</th>
                    <th>Invoice Number</th>
                    <th>Date submmited to Accounts for Payment</th> 
                    <th>Created By</th>
                   
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($report as $requisition)
                    <tr>
                    <td>{{$requisition->requisition_no}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
                    <td></td>
                    <td></td>
                    <td>{{$requisition->internalrequisition->user->abbrName()."   "." / ". $requisition->department->name}}</td>
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->institution->parish->name}}</td>
                    <td>{{$requisition->supplier->name}}</td>
                    <td>{{$requisition->category->name}}</td>
                    <td>{{$requisition->description}}</td>
                    <td>{{$requisition->contract_sum}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
                    @if($requisition->check)
                    <td>{{Carbon\Carbon::parse($requisition->check->created_at)->format('Y-M-d')}}</td>
                    @else
                      <td></td>
                    @endif
                    @if($requisition->approve)
                    <td>{{Carbon\Carbon::parse($requisition->approve->created_at)->format('Y-M-d')}}</td>
                    @else
                     <td></td>
                     @endif
                    
                    @if($requisition->purchase_order)
                      <td>{{Carbon\Carbon::parse($requisition->purchase_order->created_at)->format('Y-M-d')}}</td>
                    <td>{{$requisition->purchase_order->purchase_order_no}}</td>
                    @else
                    <td></td>
                    <td></td>
                    
                    @endif
                    <td>Date submmited to Accounts for Pre-Payment</td>
                    <td>Date P.O Sent to Institution</td>
                    <td>Date document returned to institution</td>
                    <td>Date Final Invoice Received</td>
                    <td>Invoice Number</td>
                    <td>Date submmited to Accounts for Payment</td> 
                    
            
                    <td>{{$requisition->user->abbrName()}}</td>

                    </tr>
                    @endforeach
                    
                 
                 
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> --}}
                </table>

                @else

                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    

                    <th>Requisition No.</th>
                    <th>Status</th>
                    <th>Requested by</th>
                   
                    <th>Estimated Cost</th>
                    <th>Currency</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>Requisition Type</th>
                    <th>Priority</th>
                    <th>Date Created</th>

                    <th>Certified IPR By</th>
                    <th>Date Certify IPR</th>
                    <th>Approved IPR By</th>
                    <th>Date Approved IPR</th>

                    <th>Commitment No</th>
                    <th>Accounting Code</th>
                    <th>Date IPR Commited</th>
                    <th>Commit By</th>

                    <th>Budget Approved</th>
                    <th>Budget Approved by</th>
                    <th>Assigned to</th>
                    <th>Assigned date</th>

                    <th>Requisition created Date</th>
                    <th>Terms</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Contract Sum</th>
                    <th>Pro. Method</th>
                    <th>Percentage Variance</th>

                    <th>Certify Requisition by</th>
                    <th>Date Certified</th>

                    <th>Requisition Approved by</th>
                    <th>Date Requisition Approved</th>

                    <th>Purchase Order #</th>
                    <th>Purchase Order Created By</th>
                    <th>Purchase Order Created Date</th>                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($report as $report) 
                   <tr>
                    <td>{{$report->requisition_no}}</td>
                    @if(isset($report->status))
                    <td> <span class ="badge bg-green">{{$report->status->name}}</span></td>
                    @else
                    <td> <span class ="badge bg-warning">Error warning</span></td>
                    @endif
         
                    <td>{{$report->user->fullName()}}</td>
                    <td>{{$report->estimated_cost}}</td>
                    <td>{{$report->currency->abbr}}</td>
                    <td>{{$report->department->name}}</td>
                    <td>{{$report->institution->name}}</td>
                    <td>{{$report->budget_approve}}</td>
                    <td>{{$report->requisition_type->name}}</td>
                    <td>{{$report->priority}}</td>
                    <td>{{$report->created_at}}</td>
                    @if($report->certified_internal_requisition)
                    <td>{{$report->certified_internal_requisition->user->fullName()}}</td>
                    <td>{{$report->certified_internal_requisition->created_at}}</td>
                    @else
                     <td></td>
                     <td></td>

                   @endif
                   @if($report->approve_internal_requisition)
                   <td>{{$report->approve_internal_requisition->user->fullName()}}</td>
                    <td>{{$report->approve_internal_requisition->created_at}}</td>
                    @else
                     <td></td>
                     <td></td>

                   @endif
                   @if($report->budget_commitment)
                   <td>{{$report->budget_commitment->commitment_no}}</td>
                   <td>{{$report->budget_commitment->account_code}}</td>
                   <td>{{$report->budget_commitment->created_at}}</td>
                   <td>{{$report->budget_commitment->user->fullname()}}</td>
                   @else
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>

                   @endif
                   @if($report->approve_budget)
                   <td>{{$report->approve_budget->created_at}}</td>
                   <td>{{$report->approve_budget->user->fullName()}}</td>


                   @else
                   <td></td>
                   <td></td>
                   @endif

                   @if($report->assignto)
                   <td>{{$report->assignto->user->fullname()}}</td>
                   <td>{{$report->assignto->created_at}}</td>
                   @else
                   <td></td>
                   <td></td>
                   @endif
                   @if($report->requisition)
                   <td>{{$report->requisition->created_at}}</td>
                  <td>{{$report->requisition->terms}}</td>
                <td>{{$report->requisition->supplier->name}}</td>
               
                <td>{{$report->requisition->category->name}}</td>
                <td>{{$report->requisition->contract_sum}}</td>
                 <td>{{$report->requisition->procurement_method->name}}</td>
                <td>{{$report->requisition->cost_variance / 100}} %</td>

                   @else
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   


                   @endif
                   @if(isset($report->requisition->check))
                  <td>{{$report->requisition->check->user->fullName()}}</td>
                  <td>{{$report->requisition->check->created_at}}</td>
                   @else
                   <td></td>
                   <td></td>
                   @endif

                   @if(isset($report->requisition->approve))
                  <td>{{$report->requisition->approve->user->fullName()}}</td>
                  <td>{{$report->requisition->approve->created_at}}</td>
                   @else

                   <td></td>
                   <td></td>
                   @endif
                   @if(isset($report->requisition->purchaseOrder))
                  <td>{{$report->requisition->purchaseOrder->purchase_order_no}}</td>
                  <td>{{$report->requisition->purchaseOrder->user->fullName()}}</td>
                  <td>{{$report->requisition->purchaseOrder->created_at}}</td>
           
                  
                   @else
                   <td></td>
                   <td></td>
                   <td></td>
                   @endif





                   </tr>
                
            
                 
                     @endforeach
                  </tbody>
                  {{-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> --}}
                </table>
               
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </div>
     </div>

@endsection


@include('partials.datatable-scripts')

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
<script src="/plugins/datatables/dataTables.select.min.js"></script>
<script src="/js/dataTables.select.min.js"></script>
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="/js/sweet/sweetalert.min.js"></script> 
 <script src="https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js"></script>
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
$(document).ready( function () {
    $('#table').DataTable({
     
     scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
         dom: 'Bfrtip',
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      
    });
    
} );



</script>

@endpush