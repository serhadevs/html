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

           <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3>{{ $internalrequisitions}}</h3>
              <h6>${{number_format($internal_requisition_sum,2)}}</h6>

                <p>Internal Request</p>
              </div>
              <div class="icon">
                <i class="ion ion-document"></i>
              </div>
              <a href="/internal_requisition" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


           <!-- ./col -->
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{$tendering }}</h3>
              <h6>${{number_format($tendering_sum,2)}}</h6>
                <p>Tendering</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3>{{$requisitions}}</h3>
              <h6>${{number_format($requisition_sum,2)}}</h6>
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
              <h6>${{number_format($purchase_Orders_sum,2)}}</h6>
                <p>Purchase Order</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
              <a href="/purchase-order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         
          {{-- @if(in_array(auth()->user()->role_id,[1,5,9,12])) --}}
         
              @if(in_array(auth()->user()->role_id,[1,12]) OR in_array(auth()->user()->role_id,[9]) AND auth()->user()->institution[1] ))
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
           {{-- end alerts --}}
          @if(auth()->user()->assignTo->isEmpty()===false)
          <div class="col-lg-5 col-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                  Task List
                  <table class="table m-0" id='table-alert'>
                    <thead>
                    <tr>
                      <th>Date</th>
                      <th>Requisition No.</th>
                      <th>View</th>
                  
                    </tr>
                    </thead>
                    <tbody>
             
                    
   
                      @foreach($assign_internal_requisitions as $internalRequisition)
                      <tr>
                      <td><a href="#">{{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</a></td>
                      <td><a href="#">{{$internalRequisition->requisition_no}}</a></td>
                      <td>
                      <button  class="btn btn-block btn-success btn-m" data-toggle="modal" data-target="#modal-lg-{{ $internalRequisition->id }}" >view</button>
                    {{-- modal start --}}
                    <div class="modal fade" id="modal-lg-{{ $internalRequisition->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Internal Requisition</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            
                            <div class="col-12">
                                <div class="card">
                    
                      
         
                  <!-- /.card-header -->
                   <div class="card-body">
                     <a href="/print_pdf/{{$internalRequisition->id}}" class="btn btn-outline-danger float-right btn-lg">Print PDF</a>
                   <div class="title">
                            <p><h4>South East Regional Health Authority</h4>
                            The Towers, 25 Dominica Drive, Kingston 5</p><br>
                  </div>
    
                              Requester:  <b>{{$internalRequisition->user->abbrName()}}</b>
    
                              <p><br>Institution: {{$internalRequisition->institution->name}}</br>
                              Departmentent: {{$internalRequisition->department->name}} </br>
                              Budget activity: {{$internalRequisition->budget_approve}}    </br>
                              Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                              Estimated Cost: {{$internalRequisition->estimated_cost}}</br>
                            </p>
    
                            <p>
                            <div class="form-group row">
                            <div class="col-sm-6">
                            Phone: {{$internalRequisition->phone}}</br>
                            Email: {{$internalRequisition->email}}</br>
                            Procurement Type: {{$internalRequisition->requisition_type->name}}</br>
                            Priority:{{$internalRequisition->priority}}</br>
                            Requisition no: {{$internalRequisition->requisition_no}}</br>
                            Commitment : {{$internalRequisition->budget_commitment->commitment_no}}</br>
                            Accounting : {{$internalRequisition->budget_commitment->account_code}}
                            </div>
                            </div>
                               
               
            
                <table id="stocks-table" class="datatables" class="table table-bordered table-responsive-md table-striped text-center">
                <thead>
                  <tr>
                    <th class="text-center">Item No.</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Measurement</th>
                    <th class="text-center">Unit Cost</th>
                    <th class="text-center">Part Number</th>
    
    
                  
                    
                  </tr>
                </thead>
                <tbody>
                   @foreach($internalRequisition->stocks as $stock)
                  <tr>
                  
                    <td>{{$stock->item_number}}</td>
                    <td>{{$stock->description}}</td>
                    <td>{{$stock->quantity}}</td>
                    <td>{{$stock->unit_of_measurement_id}}</td>
                    <td>{{$stock->unit_cost}}</td>
                    <td>{{$stock->part_number}}</td>
                
           
                  
                  </tr>
                   
               @endforeach
             
                </tbody>
              </table>
    
               <div class="row">
                <div class="col-sm-6">
                  <!-- textarea -->
                  <div class="form-group">
                    <label>General Description</label>
                  <textarea  readonly class="form-control" name="comments" rows="3">{{$internalRequisition->description}}</textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                                <label for="exampleInputFile">Attached Files</label>
                           <div class="card-body p-0">
                      {{-- <form  method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}" >
                      @csrf
                      @method('delete')  --}}
                    <table class="table table-sm" id="filetable">
                      <thead>
                        <tr>
                          <th>Filename</th>
                          <th>Option</th>
                          <th><th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($internalRequisition->attached as $file)
                        <tr> 
                        <td>
                        <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                        </td> 
                      <td> <a class="btn btn-outline-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                      </tr>
                        @endforeach 
                      </tbody>
                    </table>
                  {{-- </form> --}}
                  </div>
                   </div> 
                
              </div>        
    
               <div class="row">
                <div class="col-sm-6">
                  <!-- textarea -->
                  <div class="form-group">
                    <label>Comments/Justification</label>
                  <textarea  readonly class="form-control" name="comments" rows="3" >{{$internalRequisition->comments}}</textarea>
                  </div>
                </div>
    
    
                @if($internalRequisition->comment->isNotEmpty())
                            <div class="col-sm-6">
                              <!-- textarea -->
                              <div class="form-group">
                        <label>Refusal Comments</label>
                        <textarea  class="form-control" rows="3" disabled>
    @foreach($internalRequisition->comment as $comment)
    {{$comment->user->abbrName()}}: {{$comment->comment}}
    @endforeach
                        </textarea>
                              </div>
                            </div>
                            @endif
                
              </div>        
    
    
              <div class="form-group row">
                             
                              <div class="col-sm-6">
                                @if($internalRequisition->approve_internal_requisition)
                                Approved by: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->abbrName()}} </span></br>
                                Date:  <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->created_at}}</span></br>
                                @else
                                  Approve  by: <span class='badge badge-success'></span>
                                  @endif
    
                                  Budget Commitment by: <span class='badge badge-success'>{{$internalRequisition->budget_commitment->user->abbrName()}} </span></br>
                                  Date:  <span class='badge badge-success'>{{$internalRequisition->budget_commitment->created_at}}</span>
    
                              </div>
      
                              
                              <div class="col-sm-6">
                            @if($internalRequisition->approve_budget)
                            Budget Approve by: <span class='badge badge-success'>{{$internalRequisition->approve_budget->user->abbrName()}} </span></br>
                            Date:  <span class='badge badge-success'>{{$internalRequisition->approve_budget->created_at}}</span>
                            @else
                            Budget Approve by: <span class='badge badge-success'></span>
                              @endif
                              </div>
                            </div>
                            
    
    
    
    
    
    
    
                    </div> 
          
          </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
         
        </div> 
         
        
    
    
        </div>
        </div>
        </div>
        </div>
    
    
    
        {{-- end modal --}}
                      
                      
                      
       </td> {{--closing tag --}}
                      </tr>
                  
                      @endforeach
                      
                  
            
                    </tbody>
                  </table>


     
                </div>
                <!-- /.table-responsive -->
              </div>
          </div>  
          @endif
          {{-- end alerts --}}
          @if(empty(auth()->user()->unreadNotifications))
          @if(auth()->user()->unreadNotifications)
          <div class="col-lg-5 col-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                  Notification List
                  <table class="table m-0" id="notification-table">
                    <thead>
                    <tr>
                      {{-- <th>Track</th> --}}
                      <th>Requisition No.</th>
                      <th>Sender</th>
                      <th>Type</th>
                      {{-- <th>Institution</th>
                      <th>Department</th> --}}
                      <th>Date</th>
                      <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                 
                      @foreach(auth()->user()->unreadNotifications as $notification)
                      <tr>
                      <td>{{($notification->data['requisition_no'])}} </td>
                      <td>{{\App\User::find($notification->data['user_id'])->abbrName()}} </td>
                      <td>{{substr($notification->type,18,19)}} </td>
                      {{-- <td>{{\App\Institution::find($notification->data['institution_id'])->name}}</td>
                      
                      <td>{{\App\Department::find($notification->data['department_id'])->name}} </td> --}}
                      <td>{{$notification->created_at}}</td>
                      {{-- <td>{{$notification->data['email']}} </td> --}}
                       <td>
                       <a  href="/dashboard-notification/{{$notification->id}}" class="btn btn-block btn-danger btn-m" >remove</a> 
                      </td>
                    </tr>
                      @endforeach
                  
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
          </div>
          @endif
          @else

          @endif
     
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