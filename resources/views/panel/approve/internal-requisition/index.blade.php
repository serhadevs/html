




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}

input[type="checkbox"]{
  width: 20px; /*Desired width*/
  height: 20px; /*Desired height*/
  /* cursor: pointer;
  -webkit-appearance: none;
  appearance: none;
   */
}


</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Internal Requisition</h1>
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
              
          <div class="col-12">
            <div class="card">
              {{-- <div class="card-header">
                  
                  <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a>
                <h3 class="card-title">A list of all procurement requisition </h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
                {{-- <form class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
                  @csrf --}}
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    {{-- <th></th> --}}
                    <th>Aproval</th>
                    <th>Requisition_no</th>
                    <th>Date Receive</th>
                    <th>Parish</th>
                    <th>Cost Centre</th>
                    <th>Priority</th>
                    <th>Procurement Type</th>
                    <th>Request By</th>
                    <th>Option</th>
                    <th></th>
                    {{-- <th></th> --}}
              
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($internalRequisitions as $internal)
                    <tr>
                     {{-- <td>{{$internal->id}}</td> --}}
                     @if($internal->approve_internal_requisition)
                     @if($internal->approve_internal_requisition->is_granted===1)
                    <td> <span class ="badge bg-green">Approved</span></td>
                    @elseif($internal->approve_internal_requisition->is_granted===0)
                    <td> <span class ="badge bg-yellow">Refused</span></td>
                    @endif
                    @else
                    <td> <span class ="badge bg-red">Uncheck</span></td>
                    @endif
                  <td>{{$internal->requisition_no}}</td>
                  <td>{{$internal->created_at}}</td>
                  <td>{{$internal->institution->parish->name}}</td>
                  <td>{{$internal->institution->code}}</td>
                  <td>{{$internal->priority}}</td>
                    <td>{{$internal->requisition_type->name}}</td>
                  <td>{{$internal->user->firstname[0]}}.{{$internal->user->lastname}}</td>
                
              
                   
                     
                   
                    <td> <a href="/approve-internal-requisition/{{$internal->id}}" class="btn btn-block btn-success btn-sm">View</a>
                      @if($internal->approve_internal_requisition )
                      <td> <a class="btn btn-block btn-warning btn-sm" onclick="undo({{$internal->id}})">Undo</a></td>
                      @else
                      <td> <button  class="btn btn-block btn-warning btn-sm" onclick="undo({{$internal->id}})"disabled>Undo</button></td>
                      @endif
                    </td> 


                    </tr>
                    @endforeach
                    
                  
                 
                  </tbody>
                  
                </table>
              </form>
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
$(document).ready( function () {
    $('#table').DataTable({
         "scrollX": true,
         deferRender:true,
         select: true,
         columnDefs: [
    {
        targets: -1,
        className: 'dt-body-right'
    }
  ]
    });
    
} );


function undo(internal_requisition_id){
   
   swal({
   title: "Are you sure you want to undo?",
   text: "Tip: Always ensure that you review each internal requisition",
   icon: "warning",
   buttons: [ 
     'No, cancel it!',
     'Yes, I am sure!'
   ]
 }).then(isConfirm => {
   if (isConfirm) {
    //  console.log("approve");
     $.get( {!! json_encode(url('/')) !!} + "/undo-approve-internal-requisition",{ _method: "POST",data:{internal_requisition_id:internal_requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
    //  console.log(data);
    //  console.log('test');
       if (data == "success") {
         swal(
           "Done!",
           "Internal Requisition approval was undo",
           "success").then(esc => {
             if(esc){
               location.reload();
             }
           });
         }else{
           swal(
             "Oops! Something went wrong.",
             "The Internal Requisition cannot undo because it was already process to budget commitment.",
             "error");
           }
         });
       }
  
   });
}
 

 



</script>

@endpush

