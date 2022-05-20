

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User List</h1>
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
          
                  <a href="user/create" class="btn btn-outline-success float-left">Create User</a>
                <h3 class="card-title float-right">A list of all Users </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center"></th>
                    <th></th>
                     <th></th>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Role</th>
                <th class="text-center">Telephone</th>
                <th class="text-center">Unit</th>
                <th class="text-center">Department</th>
                <th class="text-center">Institution</th>
                <th class="text-center">Email</th>
                <th class="text-center">Status</th>
               
                    
                  </tr>
                  </thead>
                  <tbody>
                     @foreach($users as $user)
                  <tr>
                    <td>
                      <a  href="/user/{{$user->id}}/edit" class="btn btn-outline-primary btn-m" >Edit</a> 
                     </td>
 
                     <td>
                     <button class="btn btn-outline-warning btn-m" onclick="resetPassword({{$user->id}})">Reset</button>
                     </td> 
 
                     <td>
                     <button class="btn  btn-outline-danger btn-m" onclick="deleteUser({{$user->id}})">Delete</button>
                     </td> 
 
                   <td>{{$user->firstname}}</td>  
                    <td>{{$user->lastname}}</td>  
                     <td>{{$user->role->name}}</td>  
                      <td>{{$user->telephone}}</td>  
                       <td>{{$user->unit->name}}</td>  
                        <td>{{$user->department->name}}</td>
                        @if($user->institution_id=== 0)
                         <td> All Institution</td>
                        @else
                        <td>{{$user->institution->name}}</td>
                        @endif
                         <td>{{$user->email}}</td>
                         
                         @if($user->status ===0)
                         <td>
                          <button class="btn  btn-danger btn-m" onclick="updateStatus({{$user->id}})">Disabled</button>
                        </td>
                        @else
                       <td><button class="btn  btn-outline-success btn-m" onclick="updateStatus({{$user->id}})">Active</button></td>
                        @endif
                             
                          {{-- onclick="deleteRequisition({{$requisition->id}})" --}}


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
         "scrollX": true
    });
    
} );




// function resetPassword(Id){
//     swal({
//         title: "Are you sure?",
//         text: "You will not be able to undo this action once it is completed!",
//         dangerMode: true,
//         cancel: true,
//         buttons: ["Cancel", "Yes, Reset Password!"],
//         closeOnConfirm: false
//     }).then(isConfirm => {
//             if (isConfirm) {
//                 $.get( {!! json_encode(url('/')) !!} + "/settings/user-control/reset/" + Id).then(function (data) {
//                     if (data == "success") {
//                         swal(
//                             "Done!",
//                             "User Password reset was successful!.",
//                             "success")
//                     }else{
//                         swal(
//                             "Oops! Something went wrong.",
//                             "User Password reset was NOT successful.",
//                             "error");
//                     }
//                 });
//             }
//         });
//     }
    
</script>


<script>
function deleteUser(Id){
    swal({
        title: "Are you sure?",
        text: "You will not be able to undo this action once it is completed!",
        dangerMode: true,
        cancel: true,
        buttons: ["Cancel", "Yes, Delete it!"],
        closeOnConfirm: false
    }).then(isConfirm => {
            if (isConfirm) {
                $.get( {!! json_encode(url('/')) !!} + "/user/delete/" + Id).then(function (data) {
                   console.log(Id);
                    if (data == "success") {
                        swal(
                            "Done!",
                            "User delete was successful!.",
                            "success").then(esc => {
                                if(esc){
                                    location.reload();
                                }
                            });
                    }else{
                        swal(
                            "Oops! Something went wrong.",
                            "User delete was NOT successful.",
                            "error");
                    }
                });
            }
        });
    }




    function resetPassword(Id){
    swal({
        title: "Are you sure?",
        text: "You will not be able to undo this action once it is completed!",
        dangerMode: true,
        cancel: true,
        buttons: ["Cancel", "Yes, Reset Password!"],
        closeOnConfirm: false
    }).then(isConfirm => {
            if (isConfirm) {
                $.get( {!! json_encode(url('/')) !!} + "/user/reset/" + Id).then(function (data) {
                    if (data == "success") {
                        swal(
                            "Done!",
                            "User Password was reset successful!.",
                            "success")
                    }else{
                        swal(
                            "Oops! Something went wrong.",
                            "User Password was Not reset successful.",
                            "error");
                    }
                });
            }
        });
    }


    function updateStatus(Id){
    swal({
        title: "Are you sure?",
        text: "You are changing the user status",
        dangerMode: true,
        cancel: true,
        buttons: ["Cancel", "Yes, Change Status!"],
        closeOnConfirm: false
    }).then(isConfirm => {
            if (isConfirm) {
                $.get( {!! json_encode(url('/')) !!} + "/user/updateStatus/" + Id).then(function (data) {
                   console.log(Id);
                    if (data == "success") {
                        swal(
                            "Done!",
                            "User status was updated successful!.",
                            "success").then(esc => {
                                if(esc){
                                    location.reload();
                                }
                            });
                    }else{
                        swal(
                            "You dont have the privillege to disable user",
                            "User NOT status was updated.",
                            "error");
                    }
                });
            }
        });
    }

</script>  

@endpush