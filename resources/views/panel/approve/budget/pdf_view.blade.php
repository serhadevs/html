<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
</head>
<body>
  <h1>{{ $heading}}</h1>
  <h3>{{ $heading2}}</h3>
  <div>
    <div class="card-body">
        <div class="title">
                 {{-- <p><h4>South East Regional Health Authority</h4>
                 The Towers, 25 Dominica Drive, Kingston 5</p><br>
                 </div> --}}

                 <p>
                 <table style="width:100%">
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  <tr>
                    <td>Requester: <b>{{$internalRequisition->user->abbrName()}}</b></td>
                    <td>Institution: {{$internalRequisition->institution->name}}</td>
                  </tr>
                 
                  <tr>
                    <td>Budget officer approved: {{$internalRequisition->budget_approve}}</td>
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
                  </tr>

                  <tr>
                    <td>Requisition no:{{$internalRequisition->requisition_no}}</td>
                  </tr>
                    



                </table>
              </p>
              </br>
            </br>
          </br>
        </br>

        <p>
   <table id="table" style="width:100%" >
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

        </p>
  </br>
  </br>
  <br>
  <br>
  <p>
   <div class="row">
     <div class="col-sm-6">
       <!-- textarea -->
       <div class="form-group">
         <label>Comments/Justification</label>
       <textarea  readonly class="form-control" name="comments" rows="3">{{$internalRequisition->comments}}</textarea>
       </div>
     </div>
     
   </div>        
  </p>




     
         <br>
   <br>
 

             
         



               <table style="width:100%">
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <td>Approved by: {{$internalRequisition->approve_internal_requisition->user->abbrName()}}</td>
                  <td>Budget Commitment by: {{$internalRequisition->budget_commitment->user->abbrName()}}</td>
                  @if($internalRequisition->approve_budget)
                  <td>Budget Approve by:{{$internalRequisition->approve_budget->user->abbrName()}}</td>
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
</body>
</html>