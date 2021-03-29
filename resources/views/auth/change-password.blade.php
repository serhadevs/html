

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}
    @section('content')



    <div class="card-body" >
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
               <div class="container-fluid">
                  <section class="content-header">
        
              <div class="col-sm-10">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Change Your Password</h3>
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
            
                <div class="card-body">

                <form class="form-horizontal" method="Post" autocomplete="off" action="/change-password/user" >
                  @csrf
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-4">
                        <input type="password" name ="current_password" class="form-control" value="" required>
                          </div>

                        
                         </div>
                          <div class="form-group row">
                        <label for="trn" class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-4">
                        <input type="password" name ="new_password" class="form-control" value="" required>
                        </div>

                        {{-- <label for="address" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"  value=""name='telephone' id="tele" required>
                        </div> --}}
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-4 col-form-label">Confirm Password</label>
                        <div class="col-sm-4">
                        <input type="password" name ="confirm_password" class="form-control" value="" required>
                         </select> 
                        </div>
                       
                      </div>
                      </div>
                     

                        </div>
                        
                        </div>
                        <div class="row">
                        <div class="col-10">
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="submit"   class="btn btn-success float-left">Change Password</button>
                        </div>
                        </div>
                        </div>

                        

                      

                    
                      </form>

                  </div>

                  </div>
                    
                  
                    
          
              
            
            </div>
            
    
         
    @endsection


    @include('partials.datatable-scripts')

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
    @push('styles')
      <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    @push('scripts')
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/editable-table.js"></script> 
     <script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script src="/js/sweet/sweetalert.min.js"></script>
    @endpush
      
   