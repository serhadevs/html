

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
            <h1>Procurement Committee</h1>
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
              
          <div class="col-10">
            <div class="card">
              <div class="card-header">
                  
                  {{-- <a href="internal_requisition/create" class="btn btn-outline-success float-left">Create IPR</a> --}}
                <h3 class="btn btn float-right" class="card-title">Procurement Committee requisition list</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Option</th>
                    <th></th>
                    <th></th>
                    <th>Requisition No.</th>
                    <th>Requested by</th>
                    <th>Description</th>
                    <th>Contract Sum</th>
                    <th>Institution</th>    
                    <th>Priority</th>
                    <th>Supplier</th>
                    <th>Category</th>

                    <th>Date Created</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($requisitions as $requisition)
                    <tr>
                      @if($requisition->committee)
                     <td> <a href="/procurement-committee/{{$requisition->committee->id}}" class="btn btn-block btn-success btn-m" >Show</a> </td> 
                     <td><a href="/procurement-committee/{{$requisition->committee->id}}/edit" class="btn btn-block btn-outline-primary  btn-m" >Edit</a></td>
                     <td><button href="#" class="btn btn-block btn-outline-danger  btn-m"  onclick="deleteCommittee({{$requisition->committee->id}})">Delete</button></td>
                     @else
                     <td> <a href="/procurement-committee/create/{{$requisition->id}}" class="btn btn-block btn-outline-success  btn-m ">Create</button> </td> 
                     <td><button  href="#" class="btn btn-block btn-primary btn-m"  disabled>Edit</button></td>
                     <td><button href="#" class="btn btn-block btn-danger btn-m"   disabled>Delete</button></td>
                     @endif
                     {{-- <td> <a href="/procurement-committee/create/{{$requisition->id}}" class="btn btn-block btn-outline-success  btn-m ">Commit</button> </td>  --}}
                    <td>{{$requisition->requisition_no}}</td>
                    <td>{{$requisition->internalrequisition->user->abbrName()."   "." / ". $requisition->department->name}}</td>
                    <td>{{$requisition->description}}</td>
                    <td>${{number_format($requisition->contract_sum,2)}}</td>
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->internalrequisition->priority}}</td>
                    <td>{{$requisition->supplier->name}}</td>
                    <td>{{$requisition->category->name}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}</td>
            
                    

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


function deleteCommittee(Id){
  swal({
    title: "Are you sure?",
    text: "You will not be able to undo this action once it is completed!",
    dangerMode: true,
    cancel: true,
    confirmButtonText: "Yes, Delete it!",
    closeOnConfirm: false
  }).then(isConfirm => {
    if (isConfirm) {
      $.get( {!! json_encode(url('/')) !!} + "/procurement-committee/delete/" + Id).then(function (data) {
        if (data == "success") {
          swal(
            "Done!",
            "Internal Requisition was successfully deleted!",
            "success").then(esc => {
              if(esc){
                location.reload();
              }
            });
          }
          else if(data=="fail"){
            swal("Error",
            "This requisition is already approved by the head of entity",
            "error");
          }
          else{
            swal(
              "Oops! Something went wrong.",
              "Internal Requisition was NOT deleted.",
              "error");
            }
          });
        }
      });
    }



    
</script>

@endpush