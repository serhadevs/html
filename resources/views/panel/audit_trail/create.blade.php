

@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Audit Trail</h1>
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
                <th class="text-center">id</th>
                <th class="text-center">User Name</th>
                <th class="text-center">Event</th>
                <th class="text-center">Module Type</th>
                <th class="text-center">Auditable ID</th>
                <th class="text-center">New Values</th>
                <th class="text-center">Old Values</th>
                
                <th class="text-center">URL</th>
                <th class="text-center">IP Address</th>

                <th class="text-center">Browser</th>
                <th class="text-center">Created at</th>
            
                    
                  </tr>
                  </thead>
                  <tbody>
                @foreach($auditables as $auditable)
                <tr>
                <td>{{$auditable->id}}</td>
                <td>{{$auditable->user->abbrName()}}</td>
                <td>{{$auditable->event}}</td>
                <td>{{$auditable->auditable_type}}</td>
                <td>{{$auditable->auditable_id}}</td>
               
                {{-- <td>{{$auditable->created_at}}</td> --}}
                
              
                <td>
                  @foreach($auditable->new_values as $values)
                 
                 {{$values. "  ". ''}}
               
                  @endforeach

                </td>
                <td>
                  @foreach($auditable->old_values as $values)
                 
                 {{  $values  }}
               
                  @endforeach

                </td>
                <td>{{$auditable->url}}</td>
                <td>{{$auditable->ip_address}}</td>
                <td>{{$auditable->user_agent}}</td>
                <td>{{$auditable->created_at}}</td>
                {{-- <td> 
                <button  href="#" class="btn btn-block btn-primary btn-m" >View</button> 
                </td>
                </tr> --}}

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



    
</script>




@endpush