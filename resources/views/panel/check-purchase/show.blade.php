




@extends('layouts.panel-master')

{{-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">  --}}

@section('content')
<style type="text/css">
table.dataTable tbody td {
    outline: none;
}

.title{
text-align: center;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>  Accept Requisition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item "><a href="/dashboard">Home</a></li>
              {{-- <li class="breadcrumb-item active">DataTables</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
      <div class="container-fluid">
          
        <div class="row">
              
          <div class="col-10">
            <div class="card">
              {{-- <div class="card-header">
                  
                  <a href="requisition/create" class="btn btn-success float-right">Create Requisition</a>
                <h3 class="card-title">A list of all procurement requisition </h3>
              </div> --}}
              <!-- /.card-header -->
              <div class="card-body">
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p><br>
                        </div>

                      Requester:  <b>{{$requisition->internalrequisition->user->firstname[0]}}. {{$requisition->internalrequisition->user->lastname}}</b>

                        <p><br>Institution: {{$requisition->institution->name}}</br>
                          Departmentent: {{$requisition->department->name}} </br>
                          {{-- Cost Centre: {{$requisition[0]->cost_centre}}    </br> --}}
                          Date Ordered: {{Carbon\Carbon::parse($requisition->created_at)->format('Y-M-d')}}
                         
                        </p>

                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                        Requisition Type: {{$requisition->internalrequisition->requisition_type->name}}</br>  
                        Cost Centre: {{$requisition->cost_centre}}</br>
                        Description: {{$requisition->description}}</br>
                        TCC Number: {{$requisition->tcc}}</br>
                        TCC Expired: {{$requisition->tcc_expired_date}}</br>
                        Contract Sum: {{$requisition->contract_sum}}</br>
                        {{-- Date Required: {{$requisition->date_require}}</br> --}}
                        Requisition no.: {{$requisition->internalrequisition->requisition_no}}</br> 

                        </div>
                        
                        <div class="col-sm-6">
                        Procurement Method: {{$requisition->procurement_method->name}}</br>
                        Commitment: {{$requisition->commitment_no}}</br>
                        Category: {{$requisition->category->name}} </br>
                        TRN: {{$requisition->trn}}</br>
                        Estimate Cost: {{$requisition->internalrequisition->estimated_cost}} </br>
                        Cost Variance: {{$requisition->cost_variance}} </br>
                       
                        

                        </div>
                        </div>
                        </p> 
                        <p>
                        <div class="form-group row">
                        <div class="col-sm-6">
                      
                    
                     <h3 class="card-title">Recommended Supplier</h3>
                        <input type="text" class="form-control" value="{{$requisition->supplier->name}}" readonly >
                        </div>
                 
                     
                        <div class="col-sm-6">
                  
                     
                        <h3 class="card-title"> Supplier Address</h3>
                        <input type="text" class="form-control" id="inputEmail3" value="{{$requisition->supplier->address}}" readonly>
                   
                        </div>
                      
                        </div>
                        </p> 
                          
                <div class="col-sm-12">
                {{-- <div class="card" > --}}
                {{-- <div class="card-body"> --}}
                {{-- <h3 class="card-header text-center font-weight-bold text-uppercase py-4">requisitions</h3> --}}
              
    
          <table id="table" class="table table-bordered table-responsive-md table-striped text-center">
            <thead>
              <tr>
                <th class="text-center">Item No.</th>
                <th class="text-center">Description</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Measurement</th>
                <th class="text-center">Unit Cost</th>
                <th class="text-center">Part Number</th>
     


              
                
              </tr>
            </thead>
            <tbody>
               @foreach($requisition->internalrequisition->stocks as $stock)
              <tr>
              
                <td>{{$stock->item_number}}</td>
                <td>{{$stock->description}}</td>
                <td>{{$stock->quantity}}</td>
                <td>{{$stock->unit_of_measurement_id}}</td>
                <td>{{$stock->unit_cost}}</td>
                <td>{{$stock->part_number}}</td>

              
              </tr>
               
           @endforeach
            
            </tbody>
          </table>
     
      {{-- </div> --}}
    {{-- </div> --}}
    <!-- Editable table -->
                      
    </div>
     <div class="col-sm-6">
                            <label for="exampleInputFile">Support Documents</label>
                       <div class="card-body p-0">
                  {{-- <form  method="Post" autocomplete="off" action="/requisition/{{$requisition->id}}" >
                  @csrf
                  @method('delete')  --}}
                <table class="table table-sm" id="filetable">
                  <thead>
                    <tr>
                      <th>Filename</th>
                      <th>Option</th>
                      <th><th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(App\File_Upload::where('requisition_id',$requisition->id)->get() as $file)
                    <tr> 
                    <td>
                    <input  value="{{$file->filename}}" class='productname' id="product_name" type='text' size="5" style='border:none;outline:none;background: transparent;' required>
                    </td> 
                  <td> <a class="btn btn-primary " href="{{ asset('storage/documents/'.$file->filename)}}">View</a></td>
                    <td> <button class="btn btn-danger" onclick="deleteFile({{$file->id}})" type="button" disabled >Remove</button></td>
                  </tr>
                    @endforeach
                  </tbody>
                </table>
              {{-- </form> --}}
              </div>
              <br>
              <br>
               </div> 
                        <div class="form-group row">
                        <div class="col-sm-6">
                          @if($requisition->check)
                          @if($requisition->check->is_checked===1)
                          Accepted by: <span class='badge badge-success'> {{$requisition->check->user->firstname[0]}}. {{$requisition->check->user->lastname}}</span>
                          @else
                          Accepted by: 
                          @endif
                          @endif
                          <hr style="width:50%;text-align:left;margin-left:0"> </hr>
                        </div>
                        <div class="col-sm-6">
                                            
                        </div>
                      
                        </div>
                        
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
       
                        <div class="col-10">
                           @if($requisition->check) 
                          {{-- @if( $requisition->checked && $requisition->check->is_checked=== 1) --}}
                          
                        <button type="button"   class="btn btn-warning" disabled >Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"  onclick="Accept('{{$requisition->id}}');"disabled>Accept</button></br>
                      @else
                        <button type="button"   class="btn btn-warning"  data-toggle="modal" data-target="#modal-lg">Refuse</button>
                        <button type="button"   class="btn btn-primary float-right"  onclick="Accept('{{$requisition->id}}');" >Accept</button></br>
                          @endif
                      </div>
                        </br>

       


                        {{-- //modal  --}}

                        <div class="modal fade" id="modal-lg">
                          <div class="modal-dialog modal-m">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Refuse Requisition</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                 <div class="card-body">
                                  <form  id='form-refuse' class="form-horizontal" method="Post" autocomplete="off" action="/check-purchase" >
                                    @csrf 
                                     <div class="form-group row">
                                    <label for="cost-centre" class="col-m-4 col-form-label">Comments</label>
                                    <div class="col-m-8">
                                        <textarea type="text" style="width:400px; height:200px;" value="{{Request::old('comment')}}" id="comment" name='comment'></textarea>
                                    </div>
                                    <input type="hidden" name='requisition_id' id="requisition_id" value="{{$requisition->id}}"> 
                                    </div>
   

                                 
                                </form>

                        
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                <button type="submit"  class="btn btn-primary float-right" id="post" onclick="Refuse('{{$requisition->id}}');">Send</button>
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>




                        {{-- //end --}}
                        </div>
                      </div>
                    </div>
</br>

@endsection


@include('partials.datatable-scripts')

@push('styles')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush


@push('scripts')
{{-- <script src="/plugins/datatables/dataTables.select.min.js"></script> --}}
{{-- <script src="/js/dataTables.select.min.js"></script> --}}

<script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/pages/dashboard.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
 <script src="/js/sweet/sweetalert.min.js"></script> 
 
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

function Accept(requisitionId){
   swal({
        title: "Are you sure you want to accept the selected applications?",
        text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "success",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,refuse:0,check:1},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was accepted and will shortly be forwarded for approval.",
                "success").then(esc => {
                  if(esc){
                    location.reload();
                  }
                });
              }else{
                swal(
                  "Oops! Something went wrong.",
                  "Application(s) were NOT approved",
                  "error");
                }
                location.href='/check-purchase';
               
              });
            }
       
        });
}


// function RefuseRequisition(requisitionId) {
   
//         $(this.form).submit();
//         console.log('submit');
    
//         $('#modal-lg').modal('hide');
//         // e.preventDefault();
//         $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,refuse:1,check:0}
//                // data: id,
//                 // success: function(data){
//                 //     alert("Successfully submitted.");
//                 //     location.href='/check-purchase';
//                 // }
              
//               });
//               alert("Successfully submitted.");
//               location.href='/check-purchase';
//               console.log(data);

          
            
//     }




    // $(function () {
    // $('body').on('click', '#post', function (e) {
    //     $(this.form).submit();
    //     console.log('submit');
    
    //     $('#modal-lg').modal('hide');
    //     e.preventDefault();
    //         $.ajax({
    //             url: '/check-purchase',
    //             type: 'POST',
    //             // data:{requisitionId:requisitionId}
    //             data: $("#form-refuse").serialize(),
    //             // success: function(data){
    //             //     alert("Successfully submitted.");
    //             //     location.href='/check-purchase';
    //             // }
              
    //           });
    //           alert("Successfully submitted.");
    //           location.href='/check-purchase';
    //           console.log(data);

    //          });
            
    // });

function Refuse(requisitionId){
  var comment = $('#comment').val();
  console.log(comment);
   swal({
        title: "Are you sure you want to refuse the selected applications?",
        // text: "Tip: Always ensure that you review each purchase requisition thoroughly before approval.",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ]
      }).then(isConfirm => {
        if (isConfirm) {
          // console.log("app type:" +  requisitionId);
          $.post( {!! json_encode(url('/')) !!} + "/check-purchase",{ _method: "POST",data:{requisitionId:requisitionId,refuse:1,check:0,comment:comment},_token: "{{ csrf_token() }}"}).then(function (data) {
          console.log(data);
            if (data == "success") {
              swal(
                "Done!",
                "Purchase requisition was refuse and will send an email to the requester.",
                "success").then(esc => {
                  if(esc){
                    location.reload();
                  }
                });
              }else{
                swal(
                  "Oops! Something went wrong.",
                  "Application(s) were NOT approved",
                  "error");
                }
                location.href='/check-purchase';
               
              });
            }
       
        });
        $('#modal-lg').modal('hide');
}

  


</script>

@endpush

