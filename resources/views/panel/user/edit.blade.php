

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
                        <h3 class="card-title">Edit User</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/user/{{$user->id}}" >
                  @csrf
                   @method('PATCH') 
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-4">
                        <input type="text" name ="first_name" class="form-control" value="{{$user->firstname}}" required>
                          </div>

                        <label for="supplier_code" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-4">
                        <input type="text" id="last_name" name ="last_name" class="form-control" value="{{$user->lastname}}" required>
                          </div>
                         </div>
                          <div class="form-group row">
                        <label for="trn" class="col-sm-2 col-form-label">Role</label>
                        @if(in_array(auth()->user()->role_id,[1,12,15]))
                        <div class="col-sm-4">
                          <select type="input" class="form-control" name="role" id="role" required>
                            {{-- <option value="">select type </option> --}}
                            @foreach($roles as $role)
                            @if($role->id === $user->role->id)
                            <option selected value="{{ $role->id }}" >{{ $role->name }}</option>
                            @else
                            <option  value="{{$role->id}}" >{{$role->name}}</option>
                            @endif
                            @endforeach
                            
                           </select> 
                          </div>


                      @else
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="role" id="role" >
                          @foreach($roles->except([1,12,15]) as $role)
                          @if($role->id === $user->role->id)
                          <option selected value="{{ $role->id }}" >{{ $role->name }}</option>
                          @else
                         <option  value="{{$role->id}}" >{{$role->name}}</option>
                        @endif
                          @endforeach
                          
                         </select> 
                        </div>
                        @endif

                        <label for="address" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"  value="{{$user->telephone}}"name='telephone' id="tele" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">

                        
                         

                        @if(in_array(auth()->user()->role_id,[1,3,12,15]))
                        <select type="input" class="form-control" name="institution" id="institution" required>
                         <option  value="0" >All Institutions</option>
                           @foreach($institutions as $institution)
                          @if($institution->id === $user->institution_id)
                          <option selected value="{{ $institution->id }}" >{{ $institution->name }}</option>
                          @else
                         
                         <option  value="{{$institution->id}}" >{{$institution->name}}</option>
                        @endif
                          @endforeach
                         </select> 
                         @else
                         

                         <select type="input" class="form-control" name="institution" id="institution">
                          @foreach($institutions as $institution)
                         @if($institution->id === $user->institution->id)
                         <option selected value="{{ $institution->id }}" >{{ $institution->name }}</option>
                         @else
                        <option  value="{{$institution->id}}" >{{$institution->name}}</option>
                       @endif
                         @endforeach
                        </select> 
                         @endif


                        </div>
                        <label for="date-required" class="col-sm-2 col-form-label">Department</label>
                      
                        <div class="col-sm-4">
                         <select type="input" class="form-control" name="department" id="department" required>
                          @foreach($departments as $department)
                          @if($department->id === $user->department_id)
                          <option selected value="{{ $department->id }}" >{{ $department->name }}</option>
                          @else
                         <option  value="{{$department->id}}" >{{$department->name}}</option>
                        @endif
                          @endforeach
                          
                         </select>  
                        </div>
                      </div>
                      </div>
                      <div class="form-group row">
                        <label for="cost-centre" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"  name="email" id="email" value="{{$user->email}}"required>
                        </div>
                        
                        <label for="date-of-last" class="col-sm-2 col-form-label">Unit</label>
                        <div class="col-sm-4">
                          <select type="input" class="form-control" value="" name="unit_id" id="unit" required>
                           @foreach($units as $unit)
                          @if($unit->id === $user->unit_id)
                          <option selected value="{{ $unit->id }}" >{{ $unit->name }}</option>
                          @endif
                          @endforeach


                            
                          </select>
                          </div> 
                        </div>
                         {{-- <div class="form-group row">
                         <label for="cost-centre" class="col-sm-2 col-form-label">FAX</label>
                        <div class="col-sm-4">
                          <input type="tele" class="form-control"  name="fax" id="fax" placeholder="">
                        </div>
                        </div> --}}
                        
                         @if(in_array(auth()->user()->role_id,[1,3,12,15]) OR in_array(3,auth()->user()->userRoles_Id()->toArray()))
                    
                        <label for="" class="col-sm-12 col-form-label">Access Control</label>
                        <div class="row">
                        <label for="institutions" class="col-sm-2 col-form-label">Institutions</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="institutions[]" multiple="multiple" id="institutions" >
                          {{-- <option value="">select type </option> --}}
                       
                          @foreach($user->institution_users as $institution)
                         <option selected='selected' value="{{$institution->institution->id}}" >{{$institution->institution->name}}</option>
                          @endforeach
                          @foreach($institutions->diff($user->institution_users) as $facility)
                          <option value="{{$facility->id}}"> {{$facility->name}} </option>
                          @endforeach                         
                         </select> 
                        </div>
                          </div>
                          </br>
                         <div class="row">
                         <label for="departments" class="col-sm-2 col-form-label">Departments</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="departments[]" multiple="multiple" id="departments" >
                        @foreach($user->department_users as $department)
                         <option selected='selected' value="{{$department->department->id}}" >{{$department->department->name}}</option>
                          @endforeach
                          @foreach($departments->diff($user->department_users) as $department)
                          <option value="{{$department->id}}"> {{$department->name}} </option>
                          @endforeach    
                         </select> 
                        </div>
                        </div>
                        </br>

                        <div class="row">
                         <label for="units" class="col-sm-2 col-form-label">Units</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="units[]" multiple="multiple" id="units" >
                        @foreach($user->unit_users as $unit)
                         <option selected='selected' value="{{$unit->unit->id}}" >{{$unit->unit->name}}</option>
                          @endforeach
                          @foreach($units->diff($user->unit_users) as $unit)
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
                          @foreach($user->user_roles as $user_role)
                          <option selected='selected' value="{{$user_role->role->id}}" >{{$user_role->role->name}}</option>
                           @endforeach
                         @foreach($roles->except([1,4,6,10,11,12,14]) as $role)
                         <option value="{{$role->id}}"> {{$role->name}} </option>
                         @endforeach
 
                          </select> 
                         </div>
                         </div>



                     
                        @else
                        <div class="form-group row">
                        <label for="" class="col-sm-12 col-form-label">Access Control</label>
                        <label for="institutions" class="col-sm-2 col-form-label">Institutions</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="institutions[]" multiple="multiple" id="institution" disabled >
                          {{-- <option value="">select type </option> --}}
                          @foreach($user->institution_users as $institution)
                         <option selected='selected' value="{{$institution->institution->id}}" >{{$institution->institution->name}}</option>
                          @endforeach
                          @foreach($institutions->diff($user->institution_users) as $facility)
                          <option value="{{$facility->id}}"> {{$facility->name}} </option>
                          @endforeach                         
                         </select> 
                        </div>
                         </br>

                      
                          <label for="departments" class="col-sm-2 col-form-label">Departments</label>
                         <div class="col-lg-10">
                         <select class="form-control multiple-select" name="departments[]" multiple="multiple" id="departments" disabled >
                         @foreach($user->department_users as $department)
                          <option selected='selected' value="{{$department->department->id}}" >{{$department->department->name}}</option>
                           @endforeach
                           @foreach($departments->diff($user->department_users) as $department)
                           <option value="{{$department->id}}"> {{$department->name}} </option>
                           @endforeach    
                          </select> 
                         </div>
                      

                        <label for="units" class="col-sm-2 col-form-label">Units</label>
                        <div class="col-lg-10">
                          <select class="form-control multiple-select" name="units[]" multiple="multiple" id="units" disabled>
                            @foreach($user->unit_users as $unit)
                             <option selected='selected' value="{{$unit->unit->id}}" >{{$unit->unit->name}}</option>
                              @endforeach
                              
                             </select> 
                        </div>

                        <label for="roles" class="col-sm-2 col-form-label">Roles</label>
                        <div class="col-lg-10">
                        <select class="form-control multiple-select" name="roles[]" multiple="multiple" id="roles" disabled>
                         @foreach($user->user_roles as $user_role)
                         <option selected='selected' value="{{$user_role->role->id}}" >{{$user_role->role->name}}</option>
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
                        <button type="submit"   class="btn btn-outline-primary float-right btn-lg">Update</button>
                        </div>
                        </div>
                        </div>

                        

                      

                    
                      </form>

                  </div>

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
      
   