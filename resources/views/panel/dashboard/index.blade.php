@extends('layouts.panel-master')
@push('style')
<meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
@endpush
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{Auth()->user()->institution->name}}</a></li>
              {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
            {{-- </ol>
          </div><!-- /.col --> --}} 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  
      <div class="card-body">
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3>{{$requisitions}}</h3>

                <p> Requisition</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/requisition" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{$purchase_Orders}}<sup style="font-size: 20px"></sup></h3>

                <p>Purchase Order</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/purchase-order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>{{$user}}</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{$departments}}</h3>

                <p>Departments</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
         
              @if(auth()->user()->role_id ===1 OR auth()->user()->role_id ===2)
          <div class="col-lg-6 col-6">
            <!-- small box -->
            {!! $chart->container() !!}
            {!! $chart->script() !!}
          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            {!! $chart2->container() !!}
            {!! $chart2->script() !!}
          </div>
           <div class="col-lg-10 col-8">
            <!-- small box -->
            {!! $chart3->container() !!}
            {!! $chart3->script() !!}
          </div>
          @endif

          {{-- alerts --}}
          <div class="col-lg-5 col-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                  Alerts
                  <table class="table m-0" id ="table-alert">
                    <thead>
                    <tr>
                      <th>Date</th>
                      <th>Requisition No.</th>
                      <th>Status</th>
                  
                    </tr>
                    </thead>
                    <tbody>
                    
                    
   
                      @foreach($alerts as $alert)
                      <tr>
                      <td><a href="#">{{Carbon\Carbon::parse($alert->created_at)->format('Y-M-d')}}</a></td>
                      <td><a href="#">{{$alert->num}}</a></td>
                      <td><a href="#">{{substr($alert->type,18,26)}}</a></td>
                      </tr>
                      @endforeach
                      
                  
            
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
          </div> 
          {{-- end alerts --}}
          
          <div class="col-lg-5 col-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                  Notifications
                  <table class="table m-0" id="table">
                    <thead>
                    <tr>
                      {{-- <th>Track</th> --}}
                      <th>Requisition No.</th>
                      <th>Sender</th>
                      <th>Type</th>
                      <th>Institution</th>
                      <th>Department</th>
                      <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                 
                      @foreach(auth()->user()->notifications as $notification)
                      <tr>
                      <td>{{$notification->data['requisition_no']}} </td>
                      <td>{{\App\User::find($notification->data['user_id'])->abbrName()}} </td>
                      <td>{{substr($notification->type,18,19)}} </td>
                      <td>{{\App\Institution::find($notification->data['institution_id'])->name}}</td>
                      
                      <td>{{\App\Department::find($notification->data['department_id'])->name}} </td>
                      <td>{{$notification->created_at}}</td>
                      {{-- <td>{{$notification->data['email']}} </td> --}}
                       {{-- <td>
                       <a  href="" class="btn btn-block btn-danger btn-m" >remove</a> 
                      </td> --}}
                    </tr>
                      @endforeach
                  
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
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
 <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
 <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
 <script src="/js/dataTables.select.min.js"></script>
 <script src="/plugins/datatables/dataTables.select.min.js"></script>
<script>


$(document).ready( function () {
    $('#table').DataTable({
         "scrollX": true,
       "searching": false,
       "pageLength": 5
    });
    
} );

$(document).ready( function () {
    $('#table-alert').DataTable({
         "scrollX": true,
       "searching": false,
       "pageLength": 5
    });
    
} );

</script>
@endpush