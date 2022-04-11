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
    <section class="content-header">
        
        <div class="col-sm-12">
                  <div class="card card-primary">
                  <div class="card-header">
                    @if($module_type === 1)
                  <h3 class="card-title">Requisition Spend Analysis</h3>
                   @else
                   <h3 class="card-title">PurchaseOrder Spend Analysis</h3>

                   @endif
                  </div>
                  </div>
              
                  </div>

                     @if(count($errors)>0)
                  <div class="col-sm-10">
            <div class="alert alert-danger">
             {{-- <a class="alert alert-danger-close"></a> --}}


              <ul>
                  @foreach($errors->all() as $error)
                  <li>{{$error}}</li>
                  @endforeach
              </ul>
              
          </div>
        </div>
      @endif  
    
          </section>
  
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{-- <a href="/pdf_spend-analysis-print/" class="btn btn-outline-danger float-right btn-lg">Print PDF</a> --}}
                  
                 
                <h3 class="btn btn float-left" class="card-title">Spend analysis report</h3>
              </div>
      <div class="card-body">
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
 
         
              {{-- @if(in_array(auth()->user()->role_id,[1,12]) OR in_array(auth()->user()->role_id,[9]) AND auth()->user()->institution[1] ) --}}
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
         
          <div class="col-lg-6 col-6">
            <!-- small box -->
            {!! $chart4->container() !!}
            {!! $chart4->script() !!}
          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            {!! $chart5->container() !!}
            {!! $chart5->script() !!}
          </div>
          <div class="col-lg-10 col-12">
            <!-- small box -->
            {!! $chart3->container() !!}
            {!! $chart3->script() !!}
          </div>
          {{-- @endif --}}

          
         
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
 <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
 <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
 <script src="/js/dataTables.select.min.js"></script>
 <script src="/plugins/datatables/dataTables.select.min.js"></script>
 <script src="/js/dataTables.select.min.js"></script>
 <script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="/js/sweet/sweetalert.min.js"></script> 
 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
 <script src=" https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 
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
    $('#notification-table').DataTable({
         "scrollX": true,
       "searching": false,
       "pageLength": 3
    });
    
} );


$(document).ready( function () {
    $('#table-alert').DataTable({
         "scrollX": true,
       "searching": false,
       "pageLength": 3
    });
    
} );

// $(document).ready( function () {
//     $('#stocks-table').DataTable({
//          "scrollX": false,
//          deferRender:true,
        
      
//     });
    
// } );


$(document).ready( function () {
    $('.datatables').DataTable({
         "scrollX": false,
         deferRender:true,
         select: true,
         "bFilter": false,
         "bPaginate": true,
        //  "bInfo": true,
           dom: 'Bfrtip',
         buttons: [
           'csv', 'excel', 'pdf'
        ]
      
    });
    
} );

</script>
@endpush