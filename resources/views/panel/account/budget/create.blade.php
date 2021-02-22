

    @extends('layouts.panel-master')

    {{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

    @section('content')
    <style type="text/css">
#second {
display:none;
}

#third{
  display:none;
}
.title{
text-align: center;
}

.hide{
  display:none;
}


</style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
               <div class="container-fluid">
                  <section class="content-header">
        
              <div class="col-sm-10">
                        <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title">Create Commitment Budget</h3>
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

                <form class="form-horizontal" method="Post" autocomplete="off" action="/budgetcommitment" enctype="multipart/form-data">
                  @csrf
                            <div class="card" style="width:82.9%">
                          <div class="card-body">
                           <div class="col-m-10">


                            <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Requester</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->user->firstname[0]}}.{{$internalrequisition->user->lastname}}" readonly>
                                <input type="hidden" class="form-control"  value="{{$internalrequisition->id}}"name='id' id="id" readonly> 
                                </div>
        
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Date Ordered</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$internalrequisition->created_at->format('d-m-Y')}}"name='date_ordered' id="date-ordered" readonly>
                                </div>
                                
                              </div>
                                  <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Institution</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->institution->name}}" readonly>
                                  {{-- <input type="hidden" name='institution' id="institute_id" value="{{auth()->user()->institution->id}}"> --}}
                                  </div>
                                  <label for="inputEmail4" class="col-sm-2 col-form-label">Departmentent</label>
                                <div class="col-sm-4">
                                  <input type="input" class="form-control" value="{{$internalrequisition->department->name}}" readonly>
                                </div>
                                
                              </div>
                              
        
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Estimated Cost </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{$internalrequisition->estimated_cost}}" name='estimated_cost' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Budget activity</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->budget_approve}}" readonly>
                                </div>
                                </div>
        
                                
                                
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Phone </label>
                                <div class="col-sm-4">
                                    <input type="tele" class="form-control" value="{{$internalrequisition->phone}}" name='phone' readonly>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">E-Mail</label>
                                <div class="col-sm-4">
                                 
                                 <input type="email" class="form-control" value="{{$internalrequisition->email}}" id='email' name='email' readonly>
                                 
                                </div>
                                </div>
        
                                <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Procurement</label>
                                <div class="col-sm-4">
                                    <input type="input" class="form-control" value="{{$internalrequisition->requisition_type->name}}" readonly>
                                
                                </div> 
                                <label for="date-of-last" class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$internalrequisition->priority}}" readonly>
                                 
                                </div>
                                </div>






                        
                        <div class="form-group row">
                        <label for="institute" class="col-sm-2 col-form-label">Commitment No:</label>
                        <div class="col-sm-4">
                        <input type="number" name="commitment_no" class="form-control" value="">
                        </div> 
                        <label for="institute" class="col-sm-2 col-form-label">Accounting Code:</label>
                        <div class="col-sm-4">
                        <input type="text" name="account_code" class="form-control" value="">
                        </div>

                        {{-- <div class="form-group row">
                        <label for="institute" class="col-sm-4 col-form-label">Accounting Code:</label>
                        <div class="col-sm-6">
                        <input type="text" name="account_code" class="form-control" value="">
                        </div>
                         
                        
                      </div> --}}

                      
                      <div class="form-group row">
                        <label for="institute" class="col-sm-4 col-form-label">Comments/Justification</label>
                        <div class="col-sm-8">
                        <textarea class="form-control" name="comments" rows="3" ></textarea>
                        </div>
                         
                        
                      </div>
                    </div>
                            
                    
                    
                        </div>
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-10">
                        {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                        <button type="Submit" class="btn btn-danger float-right" >Submit</button>
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
  











  </script>



<script>


</script>
  
 





    @endpush