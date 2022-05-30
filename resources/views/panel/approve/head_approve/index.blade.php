




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
            <h1>Head Of Entity Approval</h1>
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
             
              <div class="card-body">
                
                <table id="table" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Option</th>
                    <th></th>
                    <th>Aproval</th>
                    <th>Requisition_no</th>
                    <th>description</th>
                    <th>Date Receive</th>
                    <th>Contract Sum</th>
                    <th>Requester</th>  
                    <th>Department</th>
                    <th>Institution</th>
                    <th>Parish</th>
                    <th>Supplier Name</th>
                    <th>Cost Centre</th>
                    <th>Commitment #</th> 
                    <th>Meeting type</th>   
                
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($requisitions as $requisition)
                    <td> <a href="/entity_head_approve/{{$requisition->id}}" class="btn btn-outline-success btn-m">View</a>
                      @if($requisition->entity_head_approve)
                      <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn btn-outline-warning btn-m">Undo</button></td> 
                      @else
                      <td> <button href="#" onclick="undo({{$requisition->id}})" class="btn  btn-warning btn-m" disabled>Undo</button></td> 
                      @endif
                    {{-- <td>{{$requisition->id}}</td>  --}}
                    @if($requisition->entity_head_approve)
                     @if($requisition->entity_head_approve->is_granted ===1)
                    <td> <span class ="badge bg-green">Approved</span></td>
                      @else
                      <td> <span class ="badge bg-red">Refuse</span></td>
                      @endif
                    @else
                    <td> <span class ="badge bg-red">Uncheck</span></td>
                    @endif
                    <td>{{$requisition->requisition_no}}</td>
                    <td>{{$requisition->description}}</td>
                    <td>{{Carbon\Carbon::parse($requisition->committee->created_at)->format('d-M-Y')}}</td>
                    <td>${{number_format($requisition->contract_sum,2)}}</td>
                    <td>{{$requisition->internalrequisition->user->abbrName()}}</td>
                    <td>{{$requisition->department->name}}</td>
                    <td>{{$requisition->institution->name}}</td>
                    <td>{{$requisition->institution->parish->name}}</td>
                    <td>{{$requisition->supplier->name}}</td>
                    <td>{{$requisition->cost_centre}}</td>
                    <td>{{$requisition->commitment_no}}</td>
                    <td>{{$requisition->committee->meeting_type->name}}</td>
                    

                    </tr>
                    @endforeach
                 
                    
                 
                 
                  </tbody>
                  
                </table>
              </form>
              </div>
           
      </div>

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
   
     $.get( {!! json_encode(url('/')) !!} + "/undo_entity_head_approve",{ _method: "POST",data:{requisition_id:requisition_id},_token: "{{ csrf_token() }}"}).then(function (data) {
     console.log(data);
       if (data == "success") {
         swal(
           "Done!",
           "The procurement committee approval was undo.",
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

