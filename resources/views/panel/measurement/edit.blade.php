

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
                        <h3 class="card-title">Edit  unit of measurement</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/measurement/{{$measurement->id}}" >
                  @csrf
                  @method('patch');

                  
                       
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">

                          <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-4">
                        <input type="text" name ="name" class="form-control" value="{{$measurement->name}}" required>
                          </div>

                        <label for="supplier_code" class="col-sm-2 col-form-label">Abbr</label>
                        <div class="col-sm-4">
                        <input type="text" id="abbr" name ="abbr" class="form-control" value="{{$measurement->abbr}}" required>
                          </div>
                        
                         </div>
                          
                      <div class="form-group row">
                       
                        <label for="date-required" class="col-sm-2 col-form-label">Description</label>
                      
                        <div class="col-sm-4">
                            <input type="text" id="description" name ="description" required class="form-control" value="{{$measurement->description}}">
                          
                         </select>  
                        </div>
                      </div>
                      </div>
                      


                        </div>
                        
                        </div>
                        <div class="row">
                        <div class="col-10">
                        
                        <button type="submit"   class="btn btn-primary float-right">Update</button>
                        </div>
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
      
   