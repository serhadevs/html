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
<div class="header">
  {{-- <a href="#default" class="logo">CompanyLogo</a> --}}
   <img src="dist/img/serha_logo2.png"width="80" height="50">
   South East Regional Health Authority
  
</div>

  {{-- <img src="dist/img/serha_logo2.png"width="80" height="50">South East Regional Health Authority --}}
  {{-- <h1>{{ $heading}}</h1> --}}
  {{-- <h3>{{ $heading2}}</h3> --}}

   
               
                   <h4>Internal Purchase Request</h4>
                 <p>
                 <table style="width:100%">
                 
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
 

        
   <table id="table" style="width:100%; border: 1px solid black; border-collapse: collapse;">
     <thead>
       <tr>
         <th style="border: 1px solid black; border-collapse: collapse;">Item No.</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Description</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Quantity</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Measurement</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Unit Cost</th>
         <th style="border: 1px solid black; border-collapse: collapse;">Part Number</th>

       </tr>
     </thead>
     <tbody>
        @foreach($internalRequisition->stocks as $stock)
       <tr>
       
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->item_number}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->description}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->quantity}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->unit_of_measurement_id}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->unit_cost}}</td>
         <td style="border: 1px solid black; border-collapse: collapse;">{{$stock->part_number}}</td>
     

       
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
                  <td> Date: {{Carbon\Carbon::parse($internalRequisition->approve_internal_requisition->created_at)->format('M-d-Y') }}</td>
                  <td> Date: {{Carbon\Carbon::parse($internalRequisition->budget_commitment->created_at)->format('M-d-Y') }}</td>
                  @if($internalRequisition->approve_budget)
                  <td>Date :{{Carbon\Carbon::parse($internalRequisition->approve_budget->created_at)->format('M-d-Y')}}</td>
                  @endif
                </tr>
              
              </table>

  </div>
</body>

</html>