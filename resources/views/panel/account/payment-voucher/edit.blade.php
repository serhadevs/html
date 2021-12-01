
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
            <h1>Edit Payment Voucher</h1>
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
                 @if(count($errors)>0)
                        <div class="col-m-10">
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
              <div class="card-body">

                <form class="form-horizontal" method="Post" autocomplete="off" action="/payment-voucher" >
                  @csrf
                  @method('PATCH') 
                  
               <div class="title">
                        <p><h4>South East Regional Health Authority</h4>
                        The Towers, 25 Dominica Drive, Kingston 5</p>
                        </div>
                              <h3 class="card-header text-center font-weight-bold text-uppercase py-1">Payment Voucher</h3></br>
                    
                      
                              <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Voucher No.</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" id='voucher_no' name="voucher_no" value="{{$paymentVoucher->voucher_no}}">
                                
                              </div>
        
                                <label for="inputEmail4" class="col-sm-2 col-form-label">Voucher Date</label>
                                <div class="col-sm-4">
                                  <div class="input-group date" id="voucher_date" data-target-input="nearest">
                                  <input type="text" class="form-control datepicker-input" value="{{$paymentVoucher->voucher_date}}" name='voucher_date' data-target="#voucher_date"/>
                                    <div class="input-group-append" data-target="#voucher_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                     </div>
                                </div>
                                
                              </div>
                                  <div class="form-group row">
                                <label for="institute" class="col-sm-2 col-form-label">Cheque No.</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$paymentVoucher->cheque_no}}" id="cheque_no" name="cheque_no">
                                 
                                  </div>
        
                                <label for="inputEmail4" class="col-sm-2 col-form-label">Cheque Date</label>
                                <div class="col-sm-4">
                                  <div class="input-group date" id="cheque_date" data-target-input="nearest">
                                    <input type="text" class="form-control datepicker-input" name='cheque_date' value={{$paymentVoucher->cheque_date}} data-target="#cheque_date"/>
                                    <div class="input-group-append" data-target="#cheque_date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                     </div>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="department" class="col-sm-2 col-form-label">Commitment No.</label>
                                <div class="col-sm-4">
                               
                                <input type="input" class="form-control"  value="{{$paymentVoucher->purchaseOrder->requisition->commitment_no}}"name='commitment' id="commitment" readonly>
                              
                              </div>
                                <label for="date-required" class="col-sm-2 col-form-label">Payee</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$paymentVoucher->purchaseOrder->requisition->supplier->name}}" name='supplier' id="supplier" readonly>
                                   
                                </div>
                              </div>
                              
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Description </label>
                                <div class="col-sm-4">
                                <textarea type="text" class="form-control" value="" name='description'>{{$paymentVoucher->description}}</textarea>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">Terms</label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control"  value="{{$paymentVoucher->purchaseOrder->requisition->delivery}}"name='delivery' id="delivery" readonly>
                                 
                                 
                                </div>
                                </div>
        
                                
                                <div class="form-group row">
                                    <label for="cost-centre" class="col-sm-2 col-form-label">Institution </label>
                                    <div class="col-sm-4">
                                        <input type="input" class="form-control" value="{{$paymentVoucher->purchaseOrder->requisition->institution->name}}" name='cost_centre' disabled>
                                    </div>
                                    {{-- <label for="date-of-last" class="col-sm-2 col-form-label">P.O.</label>
                                    <div class="col-sm-4">
                                     
                                     <input type="input" class="form-control" value="" name='commitment' disabled>
                                     
                                    </div> --}}
                                    </div>
            
        
                                 <div class="form-group row">
                                <label for="cost-centre" class="col-sm-2 col-form-label">Req. No </label>
                                <div class="col-sm-4">
                                <input type="input" class="form-control" value="{{$paymentVoucher->purchaseOrder->requisition->requisition_no}}" name='requisition_no' disabled>
                                </div>
                                <label for="date-of-last" class="col-sm-2 col-form-label">P.O.</label>
                                <div class="col-sm-4">
                                 
                                 <input type="input" class="form-control" value="{{$paymentVoucher->purchaseOrder->purchase_order_no}}" name='purchase_order_no' disabled>
                                 
                                </div>
                                </div>
                                    {{-- //invoice  --}}
                                    <div id="table" class="table-editable">
                                        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success">
                                    
                                    <i class="fas fa-plus fa-2x" id = 'add' aria-hidden="true"></i></a></span>
                                  <table id="stock-table" class="table table-bordered table-responsive-md table-striped text-center">
                                    <thead>
                                      <tr>
                                        <th class="text-center">Invoice#</th>
                                        <th class="text-center">Parish</th>
                                        <th class="text-center">Institution</th>
                                        <th class="text-center">NULL Value</th>
                                         <th class="text-center">Account No.</th>
                                        <th class="text-center">Amount</th>
                                         <th class="text-center">Option</th>
                                        
                                      </tr>
                                    </thead>
                                  
                                    <tbody>
                                       @foreach($paymentVoucher->invoices as $invoice)
                                       <div class="form-group row">
                                       
                                      <tr>

                                       
                                        <td>
                                          
                                        <input name='invoice_num[]' value="{{$invoice->invoice_no}}" class='invoice_num' id="invoice_num" type='text' size="5" style='border:none;outline:none;background: transparent;'>
                                       
                                        </td>
                                        <td>
                                        
                                       
                                           <input name='parish_code[]' value="{{$invoice->parish_code}}" class='parish_code' type='text' size="10" style='border:none;outline:none;background: transparent;'>
                                        </td>
                                        <td>
                                            <input name='institution_code[]' value="{{$invoice->institution_code}}" type='text' size="10" style='border:none;outline:none;background: transparent;'>
                                        </td>
                                        
                                        <td>
                                            <input name='value[]' class='value' value="{{$invoice->value}}" id="value" type='text' size="5" style='border:none;outline:none;background: transparent;'>
                                        </td> 
                                        <td>
                                          <input name='account_num[]'size="5" value="{{$invoice->account_no}}" class='account_num' type='number'style='width:80px; border:none;outline:none;background: transparent;'>
                                        </td>
                                        <td>
                                          <input name='amount[]' class='amount' value="{{$invoice->amount}}" id="amount" type='text' size="5" style='border:none;outline:none;background: transparent;'>
                                        </td>
                                
                        
                                        <td>
                                          <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                                        </td>

                                       
                                      </tr>
                                 
                                    </div>
                                  @endforeach
                                    </tbody>
                                   
                                  </table>
                        
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <!-- textarea -->
                                      <div class="form-group">
                                        <label>Amount in words</label>
                                        <textarea class="form-control"  name="amount_in_words" rows="3">{{$paymentVoucher->amount_in_words}}</textarea>
                                      </div>
                                    </div>
                                    
                                  </div>
                                  
                                </div>
                              </div>
                                  
                                <!-- /.card-body -->
              
                                </div>
                                <div class="row">
                                  <div class="col-12">
                               
                                  <button type="submit"  class="btn btn-primary float-right">Update</button>
                                  </div>
                                  </div>
                                 
                                </form>   
                              </br>
           
            </div>
            
          <br>
          
         
        </div>

            
      
                    

      </div>
       

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
 <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/editable-table.js"></script> 
 
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


$('#table').ready(function() {
    var table = $('<table></table>').addClass('foo');
        for (var i = 0; i < 10; i++) {
                row = $('<tr></tr>');
                for (var j = 0; j < 10; j++) {
                    var rowData = $('<td></td>').addClass('bar').text('result ' + j);
                    row.append(rowData);
                }
                table.append(row);
            }

        if ($('table').length) {
             $("#someContainer tr:first").after(row);
        }
        else {
            $('#someContainer').append(table);
        }
    });

$(document).ready(function(){

  $('.btn-add-more').click(function(){
  
    var html = $('.hide').html();
    $('.img_div').after(html);
  });


   $("body").on("click",".btn-remove",function(){ 
    $('.form-group').attr('disable',true);
          $(this).parents(".form-group").remove();
      });


});




</script>

@endpush

