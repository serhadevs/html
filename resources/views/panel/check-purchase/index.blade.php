




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}
</style>
<div class="card-body">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Certify Requisitions</h1>
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
                    <th>Option</th>
                    <th></th>
                    <th>Check</th>
                    <th>Requisition_no</th>
                     <th>Description</th>
                    <th>Date Receive</th>
                    {{-- <th>Date Re-submitted</th> --}}
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                     <th>Cost Centre</th>
                    {{-- <th>Commitment #</th> --}}
                    {{-- <th>Invoice Number</th> --}}
                    
                    {{-- <th></th> --}}
                    {{-- //class="badge bg-yellow" --}}
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($requisitions as $requisition)
                    <tr>
                      <td> <a href="/check-purchase/{{$requisition->id}}" class="btn btn-block btn-outline-success btn-m">View</a></td>
                        @if($requisition->check)
                        <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn btn-outline-warning btn-m">Undo</button></td>
                      @else 
                      <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn  btn-warning btn-m" disabled >Undo</button> </td> 
                      @endif
          
                     @if($requisition->check )
                    
                     @if($requisition->check->is_checked===1 AND $requisition->approve_count===0)
                    <td> <span class ="badge bg-green">Accepted</span></td>

                    @elseif($requisition->check->where('requisition_id',$requisition->id)->count() ===1 AND $requisition->approve_count >= 1 And $requisition->institution_id != 1 AND $requisition->contract_sum >= 500000)
                    <td> <span class ="badge bg-yellow">Institute Approved</span></td>

                    @elseif($requisition->check->where('requisition_id',$requisition->id)->count() >=1 AND $requisition->approve_count >= 1)
                    <td> <span class ="badge bg-green">Accepted </span></td>
                    @elseif($requisition->check->is_checked===1)
                    <td> <span class ="badge bg-green">Accepted </span></td>
                    @endif
                    @else
                    <td> <span class ="badge bg-blue">Uncheck</span></td>
                    @endif
                    <td>{{$requisition->requisition_no}}</td>
                     <td>{{$requisition->description}}</td>
                    {{-- <td></td> --}}
                 
                  <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
                    <td>{{$requisition->department->name}}</td>
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->institution->parish->name}}</td>
                  <td>{{$requisition->supplier->name}}</td>
                  <td>{{$requisition->cost_centre}}</td>
                  {{-- <td>{{$requisition->commitment_no}}</td> --}}
                    {{-- <td>Invoice Number</td> --}}
                    {{-- <td> --}}
                      {{-- @if(!$requisition->check) 
                     <button  class="btn btn-block btn-primary btn-sm"  id ="checks" onclick="checkPR('{{$requisition->id}}');">check</button> </td> 
                      @else
                     <button  class="btn btn-block btn-primary btn-sm"  id ="checks" disabled onclick="checkPR('{{$requisition->id}}');">check</button> </td>
                     @endif
                      --}}
                     {{-- <button  class="btn btn-block btn-primary btn-sm"  id ="checks" type='submit'>check</button> </td>  --}}
                   


                    </tr>
                    @endforeach
                    
                 
                 
                  </tbody>
                  
                </table>
              {{-- </form> --}}
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
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
         columnDefs: [
    {
        targets: -1,
        className: 'dt-body-right'
    }
  ]
    });
    
} );



  // $.get( {!! json_encode(url('/')) !!} + "/foodhandlers/delete/" + permitId).then(function (data) 
 // $.post( {!! json_encode(url('/sign-off/approve')) !!}, { _method: "POST", data: {selected_items: selected_items, appTypeId: appTypeId}, _token: "{{ csrf_token() }}" }).then(function (data)
function checkPR(requisitionId){
   swal({
        title: "Are you sure you want to accept the selected applications?",
        text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was accepted and will shortly be forwarded for approval.",
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


function undo(requisition_id){
   
   swal({
   title: "Are you sure you want to undo?",
   text: "Tip: Always ensure that you review each requisition",
   icon: "warning",
   buttons: [ 
     'No, cancel it!',
     'Yes, I am sure!'
   ]
 }).then(isConfirm => {
   if (isConfirm) {
     console.log("approve");
     $.get( {!! json_encode(url('/')) !!} + "/undo-check-requisition",{ _method: "POST",data:{requisition_id:requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
     console.log(data);
       if (data == "success") {
         swal(
           "Done!",
           "Requisition was unchecked",
           "success").then(esc => {
             if(esc){
               location.reload();
             }
           });
         }else{
           swal(
             "Oops! Something went wrong.",
             "Requisition was already approved.",
             "error");
           }
         });
       }
  
   });
}
 




$(function(){
        $('#subscribe-email-form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: 'notifications/subscribe/',
                type: 'POST',
                data: $('#subscribe-email-form').serialize(),
                success: function(data){
                     $('#responsestatus').val(data);
                     $('#subscription-confirm').modal('show');    
                }
            });
        });
    });
</script>

@endpush

