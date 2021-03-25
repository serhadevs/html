

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}
    @section('content')




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
                        <label for="name" class="col-sm-2 col-form-label">Frist Name</label>
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
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="role" id="role" disabled required>
                          @foreach($roles as $role)
                          @if($role->id === $user->role->id)
                          <option selected value="{{ $role->id }}" >{{ $role->name }}</option>
                          @else
                         <option  value="{{$role->id}}" >{{$role->name}}</option>
                        @endif
                          @endforeach
                          
                         </select> 
                        </div>

                        <label for="address" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"  value="{{$user->telephone}}"name='telephone' id="tele" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="department" class="col-sm-2 col-form-label">Institution</label>
                        <div class="col-sm-4">
                        <select type="input" class="form-control" name="institution" id="institution" required>
                           @foreach($institutions as $institution)
                          @if($institution->id === $user->institution->id)
                          <option selected value="{{ $institution->id }}" >{{ $institution->name }}</option>
                          @else
                         <option  value="{{$institution->id}}" >{{$institution->name}}</option>
                        @endif
                          @endforeach
                          
                         </select> 
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
                        {{-- <label for="date-of-last" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-4">
                        <input type="tele" class="form-control" name="phone" value="">
                        </div> --}}
                        </div>
                         {{-- <div class="form-group row">
                         <label for="cost-centre" class="col-sm-2 col-form-label">FAX</label>
                        <div class="col-sm-4">
                          <input type="tele" class="form-control"  name="fax" id="fax" placeholder="">
                        </div>
                        </div> --}}
                        


                        </div>
                        
                        </div>
                        <div class="row">
                        <div class="col-10">
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="submit"   class="btn btn-success float-right">Update</button>
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
    @endpush
      
   