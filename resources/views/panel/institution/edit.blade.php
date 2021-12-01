

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
                        <h3 class="card-title">Edit Institution</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/institution/{{$institution->id}}" >
                  @csrf
                  @method('PATCH') 
                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-4">
                        <input type="text" name ="name" value="{{$institution->name}}" class="form-control"required>
                          </div>

                        <label for="supplier_code" class="col-sm-2 col-form-label">Institutiion abbr</label>
                        <div class="col-sm-4">
                        <input type="text" id="institution_code" value="{{$institution->abbr}}" name ="institution_code" class="form-control" required>
                          </div>
                        
                         </div>
                         
                      <div class="form-group row">
                       
                        <label for="date-required" class="col-sm-2 col-form-label">Parish</label>
                      
                        <div class="col-sm-4">
                         <select type="input" class="form-control" name="parish_id" id="parish_id" required>
                          <option value="">select type </option>
                          @foreach($parishes as $parish)
                          @if($parish->id === $institution->parish_id)
                          <option selected value="{{ $parish->id }}" >{{ $parish->name }}</option>
                          @else
                         <option  value="{{$parish->id}}" >{{$parish->name}}</option>
                        @endif
                          @endforeach
                          
                         </select>  
                        </div>
                       



                        <label  class="col-sm-2 col-form-label">Code</label>
                         <div class="col-sm-4">
                          <input type="number" id="code" value="{{$institution->code}}" name ="code" class="form-control" required>
                        </div>
                      </div>
                      </div>
                      
                        


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
      
   