

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}
    @section('content')



    <div class="card-body">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
               <div class="container-fluid">
                  <section class="content-header">
        
              <div class="col-sm-10">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Audit Trail</h3>
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

              </div>
            
                <div class="card-body">

                <form class="form-horizontal" method="Post" autocomplete="off" action="/audit-trail" >
                  @csrf
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Auditable Type</label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="audit_type" id="audit_type">
                          {{-- <option  value="">Select</option> --}}
                        <option value="">All auditable type </option>

                          @foreach($auditble_types as $key => $type)
                        <option value="{{$type['type']}}">{{$type['name']}}</option>

                          @endforeach
                         </select>  
                          </div>

                        <label for="supplier_code" class="col-sm-2 col-form-label">User</label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="user_id" id="user_id">
                          {{-- <option >Select</option> --}}
                        <option value="">All users </option>
                          @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->abbrName()}}</option>

                          @endforeach
                         </select>  
                          </div>
                        
                         </div>
                          <div class="form-group row">
                         <label for="cost-centre" class="col-sm-2 col-form-label">Start Date </label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="start_date" data-target-input="nearest">
                        <input type="date" class="form-control datepicker-input" name='start_date' id='start_date' value='{{Request::old('start_date')}}' data-target="#start_date"/>
                        </div>
                        
                        </div>
                        <label for="cost-centre" class="col-sm-2 col-form-label">End Date</label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="end_date" data-target-input="nearest">
                        <input type="date" class="form-control datepicker-input" name='end_date' id='end_date' value='{{Request::old('end_date')}}' data-target="#end_date"/>
                        </div>
                        
                        </div>








                          </div>

                        
                      </div>
                      
                      </div>
                      


                        </div>
                        <div class="col-10">
                      
                          <button type="submit"   class="btn btn-outline-primary float-right btn-lg">Send</button>
                          </div>
                       
                        </div>
                        
                       
        

                        

                      

                    
                      </form>

                  </div>
                
                  </div>
                </div>
               
                    
                  
      
            
          
    @endsection
  
      

    @include('partials.datatable-scripts')

    @push('styles')
      <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    @push('scripts')
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/editable-table.js"></script> 
    @endpush
      
   