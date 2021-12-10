<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
 <style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

 </style>
</head>
<body>
  <img src="dist/img/serha_logo2.png"width="80" height="50">
  <h1>{{ $heading}}</h1>
  <h3>{{ $heading2}}</h3>

   
               
                   <h4>Internal Purchase Request</h4>
                 <p>
                 <table>
                 
                  <tr>
                    <td>Requester: <b>{{$internalRequisition->user->fullName()}}</b></td>
                    <td>Institution: {{$internalRequisition->institution->name}}</td>
                    
                  </tr>
                 
                  <tr>
                    <td>Budget activity: {{$internalRequisition->budget_approve}}</td>
                    <td>Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</td>
                  </tr>
                  
                  <tr>
                    <td>Phone Number :{{$internalRequisition->phone}}</td>
                    <td>Email: {{$internalRequisition->email}}</td>
                  </tr>
                  
                  <tr>
                    <td>Procurement Type: {{$internalRequisition->requisition_type->name}}</td>
                    <td>Priority:{{$internalRequisition->priority}}</td>
                  </tr>

                 
                  <tr>
                    <td>Estimated Cost: {{$internalRequisition->estimated_cost}}</td>
                    <td>Department: {{$internalRequisition->Department->name}}</td>
                  </tr>

                  <tr>
                    <td>Requisition no:{{$internalRequisition->requisition_no}}</td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>Commitment : {{$internalRequisition->budget_commitment->commitment_no}}</td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>Accounting : {{$internalRequisition->budget_commitment->account_code}}</td>
                    <td></td>
                  </tr>

                </table>
                 </p>
            
               <br>
   <br>
 

        
   <table id="table" style="width:100%">
     <thead>
       <tr>
         <th>Item No.</th>
         <th>Description</th>
         <th>Quantity</th>
         <th>Measurement</th>
         <th>Unit Cost</th>
         <th>Part Number</th>

       </tr>
     </thead>
     <tbody>
        @foreach($internalRequisition->stocks as $stock)
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
  <br>
  <br>
      
        <div class="row">
            <div class="col-sm-6">
    
              <div class="form-group">
                <label>General Description</label>
              <p>{{$internalRequisition->description}}</p>
              </div>
            </div>
            
          </div>        
 
  
  <p>
   <div class="row">
     <div class="col-sm-6">
       <div class="form-group">
         <label>Comments/Justification</label>
       <p>{{$internalRequisition->comments}}</p>
       </div>
     </div>
     
      
  </p>




     
         <br>
   <br>
 

             
         



               <table style="width:100%">
                
                <tr>
                  <td>Approved by: {{$internalRequisition->approve_internal_requisition->user->fullName()}}</td>
                  <td>Budget Commitment by: {{$internalRequisition->budget_commitment->user->fullName()}}</td>
                  @if($internalRequisition->approve_budget)
                  <td>Budget Approve by:{{$internalRequisition->approve_budget->user->fullName()}}</td>
                  @endif
                </tr>
                <tr>
                  <td> Date: {{$internalRequisition->approve_internal_requisition->created_at}}</td>
                  <td> Date: {{$internalRequisition->budget_commitment->created_at}}</td>
                  @if($internalRequisition->approve_budget)
                  <td>Date :{{$internalRequisition->approve_budget->created_at}}</td>
                  @endif
                </tr>
                
              </table>

  </div>
</body>

</html>