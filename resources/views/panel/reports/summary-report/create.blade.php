

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Summary Report</h1>
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
          
                <h3 class="card-title float-left">Summary Report between {{$start_date->format('d-M-Y')}} and {{$end_date->format('d-M-Y')}} </h3>
                <h3 class="card-title float-right">
                @if($module_type===1)
                Purchase Requisition
                @else
                PurchaseOrder
                @endif

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                <th class="text-center">Institution Name</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Total Value</th>     
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($spend_by_parish as $parish)
                  <tr>
                    
                   <td>{{$parish->parish}}</td>  
                   <td>{{$parish->count}}</td>  
                   <td>${{number_format($parish->sums,2)}}</td>  
                    {{-- <td>{{$user->id}}</td>  
                     <td>{{$user->id}}</td>   --}}
    
                  </tr> 
                  @endforeach
                  <tr>
                    <td>Total</td>
                    <td>{{$total_count}}</td>
                    <td>${{number_format($total_sum,2)}}</td>
                    </tr>
    
                 
                 
                 
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
    //   aLengthMenu: [
    //     [25, 50, 100, 200, -1],
    //     [25, 50, 100, 200, "All"]
    // ],
    //   scrollY:        "400px",
    //     scrollX:        true,
    //     scrollCollapse: true,
    //     paging:         true,
    
    // });
    
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

</script>  

@endpush