<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
 <style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}

 </style>
</head>


<body>
  {{-- <img src="dist/img/serha_logo2.png"width="80" height="50"><h1>South East Regional Health Authority</h1>
  {{-- <h1>{{ $heading}}</h1> --}}
  {{-- <h3>{{ $heading2}}</h3> --}}
  <div class="header">
  {{-- <a href="#default" class="logo">CompanyLogo</a> --}}
   {{-- <img src="dist/img/serha_logo2.png"width="80" height="50"> --}}
    <h2>South East Regional Health Authority</h2>
    <h3>{{ $heading2}}</h3>
  
  
</div>

  <h4> Purchase Requisition</h4>

  <table style="width:100%">
                 
                  <tr>
                    <td>Requester: <b>{{$requisition->internalrequisition->user->fullName()}}</b></td>
                    <td>Requisition no.: {{$requisition->internalrequisition->requisition_no}}</td>
                    
                  </tr>
                  <tr>
                    <td>Department: {{$requisition->department->name}}</td>
                    <td>Institution: {{$requisition->institution->name}}</td>
                  </tr>
                   <tr>
                    <td>Date Ordered: {{$requisition->internalrequisition->created_at->format('d-M-Y')}}</td>
                    <td>Type: {{$requisition->internalrequisition->requisition_type->name}}</td>
                  </tr>
                  <tr>
                    <td>Estimated Cost: ${{number_format($requisition->internalrequisition->estimated_cost,2)}}</td>
                     <td>Contract Sum: ${{number_format($requisition->contract_sum,2)}}</td>
                  </tr>
                  <tr>
                   <td>Cost Centre: {{$requisition->cost_centre}}</td>
                   <td>Commitment number: {{$requisition->commitment_no}}</td>
                  </tr>
                  <tr>
                   <td>Terms: {{$requisition->delivery}}</td>
                   <td>Pro. Method: {{$requisition->procurement_method->name}}</td>
                  </tr>
                   <tr>
                   <td>Supplier:{{$requisition->supplier->name}}</td>
                   <td>Supplier Address: {{$requisition->supplier->address}}</td>
                  </tr> 
                   <tr>
                   <td>Description: {{$requisition->description}}</td>
                   <td>Category: {{$requisition->category->name}}</td>
                  </tr>
                  <tr>
                  
                   <td>Supplier TRN: {{$requisition->supplier->trn}}</td>
                    <td>Percentage Variance: {{$requisition->cost_variance}}</td>
                  </tr>
                    
</table>
<br>
<br>


   <table id="table" style="width:100%; border: 1px solid black; border-collapse: collapse;">
     <thead>
       <tr>
         <th style="border: 1px solid black; border-collapse: collapse;">Item No.</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Description</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Quantity</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Measurement</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Actual Unit Cost</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Total</th>

       </tr>
     </thead>
     <tbody>
        @foreach($requisition->internalRequisition->stocks as $stock)
       <tr>
       
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->item_number}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->description}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->quantity}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->unit_of_measurement->name}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">${{number_format($stock->actual_cost,2)}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->actual_total ? '$'.number_format($stock->actual_total,2) : '$'.number_format($stock->quantity * $stock->actual_cost,2)}}</td>
     

       
       </tr>
        
    @endforeach
  
     </tbody>
   </table>

     <div class="row">
                          
  <div class="col-sm-4">
                       
  <table class="table table-bordered table-responsive-md table-striped text-left">
  <tr >
    
     <td style="border: 1px solid black; border-collapse: collapse;">Sub total</td>
      <td style="border: 1px solid black; border-collapse: collapse;">${{number_format($requisition->internalrequisition->stocks->sum('actual_total'),2)}}</td>
    
  </tr>
   <tr>
   
     <td style="border: 1px solid black; border-collapse: collapse;">Sales Tax (15.0%)</td>
      <td style="border: 1px solid black; border-collapse: collapse;">${{number_format($requisition->internalrequisition->stocks->sum('actual_total') * .15,2) }}</td>
     
  </tr>
   <tr>

     <td style="border: 1px solid black; border-collapse: collapse;">Grand Total</td>
      <td style="border: 1px solid black; border-collapse: collapse;">${{number_format($requisition->contract_sum,2)}}</td>
     
  </tr>
 
 
  </table>


  </div> 
                  
            
            
      </div>


     <br>
     <br>
     <br>

     <table style="width:100%">
                
                <tr>
                  <td>Approved IRF by: {{$requisition->internalRequisition->approve_internal_requisition->user->fullName()}}</td>
                  <td> Date: {{Carbon\Carbon::parse($requisition->internalRequisition->approve_internal_requisition->created_at)->format('M-d-Y') }}</td>

                 </tr>

                 <tr> 
                  <td>Budget Commitment by: {{$requisition->internalRequisition->budget_commitment->user->fullName()}}</td>
                     <td> Date: {{Carbon\Carbon::parse($requisition->internalRequisition->budget_commitment->created_at)->format('M-d-Y') }}</td>
                </tr>

                <tr>
                   @if($requisition->internalRequisition->approve_budget)
                  <td>Budget Approve by:{{$requisition->internalRequisition->approve_budget->user->fullName()}}</td>
                  <td>Date :{{Carbon\Carbon::parse($requisition->internalRequisition->approve_budget->created_at)->format('M-d-Y')}}</td>
                  @endif
                </tr>

                 <tr>
                  @if($requisition->check)
                  <td>Accepted by: {{$requisition->check->user->fullName()}}</td>
                  <td>Date :{{Carbon\Carbon::parse($requisition->check->created_at)->format('M-d-Y')}}</td>
                  @else
                  <td></td>
                  <td></td>

                  @endif

                </tr>

                 <tr>
                  @if($requisition->approve)
                  <td>Approved Requisition by: {{$requisition->approve->user->fullName()}}</td>
                  <td>Date :{{Carbon\Carbon::parse($requisition->approve->created_at)->format('M-d-Y')}}</td>
                  @endif

                </tr>

               
              
              </table>

</body>


</html>
   
               
    