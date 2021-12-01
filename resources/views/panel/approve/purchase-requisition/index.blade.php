




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
<div class="card-body">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Requisitions</h1>
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
                    {{-- <th> </th> --}}
                    <th>Option</th>
                    <th></th>
                    {{-- <th>ID</th> --}}
                    <th>Aproval</th>
                    <th>Requisition_no</th>
                    <th>description</th>
                    <th>Date Receive</th>
                    {{-- <th>Date Re-submitted</th> --}}
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    <th>Cost Centre</th>
                    <th>Commitment #</th>
                    {{-- <th>Invoice Number</th> --}}
                   
                    {{-- <th></th> --}}
                    {{-- //class="badge bg-yellow" --}}
                  </tr>
                  </thead>
                  <tbody>
                   @foreach($requisitions as $requisition)
                    <td> <a href="/approve-requisition/{{$requisition->id}}" class="btn btn-outline-success btn-m">View</a>
                      @if($requisition->approve)
                      <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn btn-outline-warning btn-m">Undo</button></td> 
                      @else
                      <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn  btn-warning btn-m" disabled>Undo</button></td> 
                      @endif
                    {{-- <td>{{$requisition->id}}</td>  --}}
                    @if($requisition->approve)
                     @if($requisition->approve->is_granted===1)
                    <td> <span class ="badge bg-green">Approved</span></td>
                    @elseif($requisition->approve->is_granted===0)
                    <td> <span class ="badge bg-yellow">Refused</span></td>
                    @endif
                    @else
                    <td> <span class ="badge bg-red">Uncheck</span></td>
                    @endif
                    <td>{{$requisition->requisition_no}}</td>
                    <td>{{$requisition->description}}</td>
                    {{-- <td></td> --}}
                 
            
                    <td>{{$requisition->date_require}}</td>
                    <td>{{$requisition->department->name}}</td>
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->institution->parish->name}}</td>
                  <td>{{$requisition->supplier->name}}</td>
                  <td>{{$requisition->cost_centre}}</td>
                  <td>{{$requisition->commitment_no}}</td>
                    {{-- <td>Invoice Number</td> --}}
                    {{-- <td> --}}
                      {{-- @if(!$requisition->approve) 
                     <button  class="btn btn-block btn-primary btn-sm"  id ="approve" onclick="ApproveRquisition('{{$requisition->id}}');">Approve</button> </td> 
                      @else
                     <button  class="btn btn-block btn-primary btn-sm"  id ="approve" disabled onclick="ApproveRquisition('{{$requisition->id}}');">Approve</button> </td>
                     @endif
                      --}}
                     {{-- <button  class="btn btn-block btn-primary btn-sm"  id ="checks" type='submit'>check</button> </td>  --}}
                    

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
  </div>
</br>
</br>
    

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



  // $.get( {!! json_encode(url('/')) !!} + "/foodhandlers/delete/" + permitId).then(function (data) 
 // $.post( {!! json_encode(url('/sign-off/approve')) !!}, { _method: "POST", data: {selected_items: selected_items, appTypeId: appTypeId}, _token: "{{ csrf_token() }}" }).then(function (data)
// function ApproveRquisition(requisitionId){
   
//         swal({
//         title: "Are you sure you want to approve the selected applications?",
//         text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
//         icon: "warning",
//         buttons: [
//           'No, cancel it!',
//           'Yes, I am sure!'
//         ]
//       }).then(isConfirm => {
//         if (isConfirm) {
//           console.log("approve");
//           $.post( {!! json_encode(url('/')) !!} + "/approve-requisition",{ _method: "POST",data:{requisitionId:requisitionId},_token: "{{ csrf_token() }}"}).then(function (data) {
//           console.log(data);
//             if (data == "success") {
//               swal(
//                 "Done!",
//                 "Purchase requisition was approve and will shortly be forwarded for purchase order.",
//                 "success").then(esc => {
//                   if(esc){
//                     location.reload();
//                   }
//                 });
//               }else{
//                 swal(
//                   "Oops! Something went wrong.",
//                   "Application(s) were NOT approved",
//                   "error");
//                 }
//               });
//             }
       
//         });
// }


function undo(requisition_id){
   
   swal({
   title: "Are you sure you want to undo?",
   text: "Tip: Always ensure that you review each requisition.",
   icon: "warning",
   buttons: [ 
     'No, cancel it!',
     'Yes, I am sure!'
   ]
 }).then(isConfirm => {
   if (isConfirm) {
     console.log("approve");
     $.get( {!! json_encode(url('/')) !!} + "/undo-approve-requisition",{ _method: "POST",data:{requisition_id:requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
     console.log(data);
       if (data == "success") {
         swal(
           "Done!",
           "The Requisition approval was undo.",
           "success").then(esc => {
             if(esc){
               location.reload();
             }
           });
         }else{
           swal(
             "Oops! Something went wrong.",
             "Requisition cannot undo because it was already process to purchase order.",
             "error");
           }
         });
       }
  
   });
}
 

 


</script>

@endpush

