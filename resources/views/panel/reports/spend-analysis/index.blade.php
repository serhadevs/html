

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
                        <h3 class="card-title">Spend Analysis</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/spend-analysis" >
                  @csrf
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                            <div class="form-group row">
                              <label for="name" class="col-sm-2 col-form-label">Module type</label>
                              <div class="col-sm-4">
                              <select type="input" class="form-control" name="module_type" id="module_type" required>
                                <option value="" >Select</option>
                              <option value="1">Requisition</option>
                              <option value="2">Purchase Order</option>
                               </select>  
                                </div>
                                @if(in_array(auth()->user()->role_id,[1,3,6,10,11,12,14,15]))
                                <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                              <div class="col-sm-4">
                                <select type="input" class="form-control" name="institution_id" id="institution" required>
                                  <option value="{{auth()->user()->institution_id}}" >{{auth()->user()->institution->name}}</option>
                                  <option value=0 >All Institutions</option>
                                 @foreach($institutions->except([auth()->user()->institution_id]) as $institution)
                                 <option value="{{$institution->id}}" >{{$institution->name}}</option>
                                 @endforeach
                                </select>  
                              
                              </div>

                              @else
                              <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                              <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{auth()->user()->institution->name}}" readonly>
                                  <input type="hidden" name='institution_id' id="institute_id" value="{{auth()->user()->institution_id}}">
                                  </div>
                              
                            
                               @endif
                              </div>

                        
                          <div class="form-group row">
                         <label for="start_date" class="col-sm-2 col-form-label">Start Date </label>
                       
                        <div class="col-sm-4">
                        <div class="input-group date" id="start_date" data-target-input="nearest">
                        <input type="date" class="form-control datepicker-input" name='start_date' id='start_date' value='{{Request::old('start_date')}}' data-target="#start_date"/>
                       
                        </div>
                        
                        </div>
                        <label for="end_date" class="col-sm-2 col-form-label">End Date</label>
                       
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
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="submit"   class="btn btn-outline-primary float-right btn-lg">Send</button>
                        </div>
                        </div>
                      
                       
                       
                        </div>

                        

                      

                    
                      </form>

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
      
   