

    @extends('layouts.panel-master')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                        <h3 class="card-title">Create User</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/user" >
                  @csrf
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Frist Name</label>
                        <div class="col-sm-4">
                        <input type="text" name ="first_name" class="form-control" value="{{Request::old('first_name')}}" required>
                          </div>

                        <label for="supplier_code" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-4">
                        <input type="text" id="last_name" name ="last_name" class="form-control" value="{{Request::old('last_name')}}" required>
                          </div>
                        
                         </div>
                          <div class="form-group row">
                        <label for="trn" class="col-sm-2 col-form-label">Role</label>
                        @if(in_array(auth()->user()->role_id,[1,12]))
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="role" id="role" required>
                          <option value="">select type </option>
                          @foreach($roles as $role)
                         <option  value="{{$role->id}}" >{{$role->name}}</option>

                          @endforeach
                          
                         </select> 
                        </div>

                        @else

                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="role" id="role" required>
                            <option value="">select type </option>
                            @foreach($roles->except([1,12,14]) as $role)
                           <option  value="{{$role->id}}" >{{$role->name}}</option>
  
                            @endforeach
                            
                           </select> 
                          </div>


                        @endif

                        <label for="address" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"  value="{{Request::old('telephone')}}" name='telephone' id="tele" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="location" class="col-sm-2 col-form-label">Location</label>
                        @if(in_array(auth()->user()->role_id,[1,12]))
                        <div class="col-sm-4">
                        <select class="form-control multiple-select" name="institution" required>
                          <option value="">select institution </option>
                          <option value="0">All Institution </option>
                          @foreach($institutions as $institution)
                         <option  value="{{$institution->id}}" >{{$institution->name}}</option>

                          @endforeach
                          
                         </select> 
                        </div>
                        @else
                        <div class="col-sm-4">
                        <select class="form-control multiple-select" name="institution" required>
                          <option value="">select institution </option>
                          @foreach($institutions as $institution)
                         <option  value="{{$institution->id}}" >{{$institution->name}}</option>

                          @endforeach
                          
                         </select> 
                        </div>



                        @endif
                        <label for="date-required" class="col-sm-2 col-form-label">Department</label>
                      
                        <div class="col-sm-4">
                         <select type="input" class="form-control" value="{{Request::old('department')}}" name="department" id="department" required>
                          <option >Select Department </option>
                          @foreach($departments as $department)
                         <option  value="{{$department->id}}" >{{$department->name}}</option>

                          @endforeach
                          
                         </select>  
                        </div>
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-4">
                          <input type="text" class="form-control"  name="email" id="email" value="{{Request::old('email')}}"required>
                        </div>
                        <label for="unit" class="col-sm-2 col-form-label">Unit</label>
                        <div class="col-sm-4">
                          <select type="input" class="form-control" value="" name="unit_id" id="unit" required>
                            {{-- <option >Select unit </option> --}}
                          </select>
                            
                        </div> 
                        </div>
                       
                        @if(in_array(auth()->user()->role_id,[1,9,12]) OR in_array(9,auth()->user()->userRoles_Id()->toArray()))
                   
                        <label for="" class="col-sm-12 col-form-label">Access Control</label>
                        {{-- <hr style="width:50%;text-align:left;margin-left:0"> --}}

                           <div class="row">
                        <label for="institutions" class="col-sm-2 col-form-label">Institutions</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="institutions[]" multiple="multiple" id="institutions" >
                        @foreach($institutions as $institution)
                        <option value="{{$institution->id}}"> {{$institution->name}} </option>
                        @endforeach

                         </select> 
                        </div>
                        </div>
                        </br>


                           <div class="row">
                         <label for="departments" class="col-sm-2 col-form-label">Departments</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="departments[]" multiple="multiple" id="departments" >
                        @foreach($departments as $department)
                        <option value="{{$department->id}}"> {{$department->name}} </option>
                        @endforeach

                         </select> 
                        </div>
                        </div>
                          </br>
                        

                         <div class="row">
                         <label for="units" class="col-sm-2 col-form-label">Units</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="units[]" multiple="multiple" id="units">
                        @foreach($units as $unit)
                        <option value="{{$unit->id}}"> {{$unit->name}} </option>
                        @endforeach

                         </select> 
                        </div>
                        </div>
                      </br>


                        <div class="row">
                          <label for="roles" class="col-sm-2 col-form-label">Roles</label>
                         <div class="col-lg-10">
                         <select class="form-control multiple-select" name="roles[]" multiple="multiple" id="roles">
                         @foreach($roles->except([1,6,10,11,12,14]) as $role)
                         <option value="{{$role->id}}"> {{$role->name}} </option>
                         @endforeach
 
                          </select> 
                         </div>
                         </div>
                      @endif
                        
                       
                        
                         
                        
                      

                  </div>
                        
              </div>







                        <div class="row">
                        <div class="col-10">
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="submit"   class="btn btn-outline-primary float-right btn-lg">Save</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   


    <script>

$(document).ready(function(){
 $('#department').change(function() {
   department = $(this).val();
   $("#unit").empty();
$.ajax({
type:"GET",
url:"/getUnits",
dataType:'json', 
success: function (data) {  
              var len = 0;
              if(data != null){
              len= data.length;
           
              }
              if(len>0){
                for(var i =0; i< len;i++){
                 if(data[i].department_id == department){
                  var id = data[i].id;
                  var name = data[i].name;
                  var option = "<option value='"+id+"'>"+name+"</option>";
                 
                  $("#unit").append(option);
                  
                 }
                }
              }
           }  

});
});
});

$(document).ready(function() {
    $('.multiple-select').select2();
});
      </script>
    @endpush
      
   