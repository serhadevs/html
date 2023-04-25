

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
            <h1>Assign Internal Request</h1>
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
    <section class="content">
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  
                  {{-- <a href="irf/create" class="btn btn-success float-right">Create IR</a> --}}
                <h3 class="card-title">A list of all Internal Request</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    {{-- <th>ID</th> --}}
                    <th>Option</th>
                    <th></th>
                    <th></th>
                    <th>Requisition Number</th>
                    <th>Assignee</th>
                    <th>Assign Date</th>
                    <th>Requested by</th>
                    <th>Description</th>
                    <th>Commitment #</th>
                    <th>Estimated Cost</th>
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Budget Activity </th>
                    <th>phone</th>
                    <th>Email</th>
                    <th>Procurement Type</th>
                    <th>Priority</th>
                    <th>Date Created</th>
                    <th>Date Approved</th>
                  
                    
              
                    
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($internal_requisitions as $internal_requisition)
                    <tr>
                    {{-- <td>{{$internal_requisition->id}}</td> --}}
                      @if($internal_requisition->assignto)
                   <td> <a  href="/assign_requisition/{{$internal_requisition->id}}/edit" class="btn btn-block btn-primary btn-m">Assigned</a></td>
                    @else
                   <td> <a  href="/assign-requisition/{{$internal_requisition->id}}/create" class="btn btn-block btn-outline-primary  btn-m ">Assign</a></td>
                    @endif
                   <td> <a  href="/assign-requisition/show/{{$internal_requisition->id}}" class="btn btn-block btn-outline-success  btn-m ">View</a>
                    <td> <a  href="#" class="btn btn-block btn-outline-danger  btn-m " onclick="refusal('{{$internal_requisition->id}}');">Reject</a>
                    </td>
                    <td>{{$internal_requisition->requisition_no}}</td>
                    @if($internal_requisition->assignto)
                    <td>{{$internal_requisition->assignto->user->abbrName()}}</td>
                    <td>{{$internal_requisition->assignto->created_at}}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                    <td>{{$internal_requisition->user->abbrName()}}</td>
                    <td>{{$internal_requisition->description}}</td>
                    <td>{{$internal_requisition->budget_commitment->commitment_no}}</td>
                    <td>{{$internal_requisition->estimated_cost}}</td>
                    
                    <td>{{$internal_requisition->department->name}}</td>
                    <td>{{$internal_requisition->institution->name}}</td>
                    <td>{{$internal_requisition->budget_approve}}</td>
                    <td>{{$internal_requisition->phone}}</td>
                    <td>{{$internal_requisition->email}}</td>
                    <td>{{$internal_requisition->requisition_type->name}}</td>
                    <td>{{$internal_requisition->priority}}</td>
                    <td>{{$internal_requisition->created_at}}</td>
                    @if($internal_requisition->approve_internal_requisition)
                    <td>{{$internal_requisition->approve_internal_requisition->created_at}}</td>
                    @else
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
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        </div>
    </section>
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
      aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
      scrollY:        "600px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
    });
    
} );


function refusal(internal_requisition_id){
   swal({
        title: "Are you sure you want to refuse this requisition?",
        text: "Warning: This will reset application process to internal requisition.",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          $.get( {!! json_encode(url('/')) !!} + "/refuse-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
         
            if (data == "success") {
              swal(
                "Done!",
                "The internal requisition was refused.",
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
                location.href='/assign_requisition';
               
              });
            }
       
        });
     
}

</script>

@endpush