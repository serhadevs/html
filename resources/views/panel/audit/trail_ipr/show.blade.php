

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Trail</h1>
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
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                <th class="text-center">Requisition no.</th>
                <th class="text-center">IPR Created</th>
                <th class="text-center">Certified </th>
                <th class="text-center">Approval IPR</th>
                <th class="text-center">Commit Budget</th>
                <th class="text-center">Approve Budget</th>
                <th class="text-center">Assign IPR</th>
                <th class="text-center">Requisition</th>
                <th class="text-center">Accept Requisition</th>
                <th class="text-center">Approve Requisition</th>
                <th class="text-center">Purchase Order</th>   
                  </tr>
                  </thead>
                  <tbody>
                @foreach($internal_requisitions as $internal)
                </tr>
                  <td>{{$internal->requisition_no}}</td>
                  <td><span class='badge badge-primary'>{{$internal->user->abbrName()}}</span><br> {{Carbon\Carbon::parse($internal->created_at)->format('F d, Y')}}</td>
        
                  <td><span class='badge badge-primary'>{{$internal->certified_internal_requisition ? $internal->certified_internal_requisition->user->abbrName(). " ".Carbon\Carbon::parse($internal->certified_internal_requisition->created_at)->format('F d, Y') : ''}} </span> </td>
            
                  {{-- {{\App\User::where('institution_id',$internal->institution_id)->where('department_id',$internal->department_id)->first()['id']}} --}}
                 
                 
                 <td><span class='badge badge-primary'>{{$internal->approve_internal_requisition ? $internal->approve_internal_requisition->user->abbrName() . " ".Carbon\Carbon::parse($internal->approve_internal_requisition->created_at)->format('F d, Y'): ''}}</span></td>

                
                 <td><span class='badge badge-primary'>{{ $internal->budget_commitment ? $internal->budget_commitment->user->abbrName()." ".Carbon\Carbon::parse($internal->budget_commitment->created_at)->format('F d, Y') : " "}} </span> </td>
                 
              
                 <td> <span class='badge badge-primary'>{{$internal->approve_budget ? $internal->approve_budget->user->abbrName()." " .Carbon\Carbon::parse($internal->budget_commitment->created_at)->format('F d, Y'):''}}<span> </td>
                  <td> <span class='badge badge-primary'>{{$internal->assignto ? $internal->assignto->user->abbrName(). " " .Carbon\Carbon::parse($internal->assignto->created_at)->format('F d, Y'):''}}</span> </td>
                   <td> <span class='badge badge-primary'>{{$internal->requisition ? $internal->requisition->user->abbrName(). " " .Carbon\Carbon::parse($internal->requisition->created_at)->format('F d, Y'):''}}</span> </td>
                   <td> <span class='badge badge-primary'>{{$internal->requisition ? $internal->requisition->check->user->abbrName(). ' '.Carbon\Carbon::parse($internal->requisition->check->created_at)->format('F d, Y'):''}}</span> </td>
                    <td> <span class='badge badge-primary'>{{$internal->requisition ? $internal->requisition->approve->user->abbrName(). ' '.Carbon\Carbon::parse($internal->requisition->approve->created_at)->format('F d, Y'):''}}</span> </td>
                    <td> <span class='badge badge-primary'>{{$internal->requisition ? $internal->requisition->purchaseOrder->user->abbrName(). ' '.Carbon\Carbon::parse($internal->requisition->purchaseOrder->created_at)->format('F d, Y'):''}}</span> </td>
                  </tr>
               
                          
                @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
<s  // "scrollX": truecript src="/js/pages/dashboard.min.js"></script>
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
$(document).ready( function () {
    $('#table').DataTable({
         "scrollX": true
    });
    
} );



    
</script>




@endpush