.

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
                    <h3 class="card-title">Edit Supplier</h3>
                    </div>
                    </div>
                    </div>
      
            </section>
        
            <div class="card-body">

            <form class="form-horizontal" method="Post" autocomplete="off" action="/suppliers/{{$supplier->id}}" >
              @csrf
              @method('patch')
              
                   
                        <div class="card" style="width:82.9%">
                      <div class="card-body">
                       <div class="col-m-10">

                      <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-4">
                    <input type="text" name ="name" class="form-control" value="{{$supplier->name}}" required>
                      </div>

                    <label for="supplier_code" class="col-sm-2 col-form-label">Supplier Code</label>
                    <div class="col-sm-4">
                    <input type="text" id="supplier_code" name ="supplier_code" class="form-control" value="{{$supplier->supplier_code}}"required>
                      </div>
                    
                     </div>
                      <div class="form-group row">
                    <label for="trn" class="col-sm-2 col-form-label">TRN</label>
                    <div class="col-sm-4">
                    <input type="number" name="trn" class="form-control" value="{{$supplier->trn}}" required>
                      </div>

                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control"  value="{{$supplier->address}}"name='address' id="address"required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="department" class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" name="city" value="{{$supplier->city}}"required>
                    </div>
                    <label for="date-required" class="col-sm-2 col-form-label">Parish</label>
                  
                    <div class="col-sm-4">
                     <select type="input" class="form-control" name="parish_id" id="parish_id" required>
                      <option value="">Select type </option>
                      @foreach($parishes as $parish)
                      @if($supplier->parish_id === $parish->id)
                      <option selected  value="{{$parish->id}}" >{{$parish->name}}</option>
                      @else
                    
                     <option  value="{{$parish->id}}" >{{$parish->name}}</option>
                        @endif
                      @endforeach
                      
                     </select>  
                    </div>
                  </div>
                  </div>
                  <div class="form-group row">
                    <label for="cost-centre" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control"  name="country" id="country" value="{{$supplier->country}}" required>
                    </div>
                    <label for="date-of-last" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-4">
                    <input type="tele" class="form-control" name="phone" value="{{$supplier->phone}}"required>
                    </div>
                    </div>
                     <div class="form-group row">
                     <label for="cost-centre" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                      <input type="tele" class="form-control"  name="email" id="email" value="{{$supplier->email}}">
                    </div>
                    </div>
                    


                    </div>
                    
                    </div>
                    <div class="row">
                    <div class="col-10">
                    {{-- <button type="button"  name="next-1" id="next-1" class="btn btn-success">Next</button> --}}
                    <button type="submit"   class="btn btn-primary float-right">Update</button>
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

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
<script src="/js/dataTables.select.min.js"></script>
<script src="/js/editable-table.js"></script> 
@endpush
  
