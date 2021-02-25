<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
</head>
<body>
  <h1>{{ $heading}}</h1>
  <div>
    <div class="card-body">
        <div class="title">
                 <p><h4>South East Regional Health Authority</h4>
                 The Towers, 25 Dominica Drive, Kingston 5</p><br>
                 </div>

                   Requester:  <b>{{$internalRequisition->user->firstname[0]}}. {{$internalRequisition->user->lastname}}</b>

                   <p><br>Institution: {{$internalRequisition->institution->name}}
                   Departmentent: {{$internalRequisition->department->name}} </br>
                   Budget officer approved: {{$internalRequisition->budget_approve}}    </br>
                   Date Ordered: {{Carbon\Carbon::parse($internalRequisition->created_at)->format('Y-M-d')}}</br>
                   Estimated Cost: {{$internalRequisition->estimated_cost}}</br>
                 </p>

                 <p>
                 <div class="form-group row">
                 <div class="col-sm-6">
                 Phone: {{$internalRequisition->phone}}</br>
                 Email: {{$internalRequisition->email}}</br>
                 Procurement Type: {{$internalRequisition->requisition_type->name}}</br>
                 Priority:{{$internalRequisition->priority}}</br>
                 </div>
                 
                 <div class="col-sm-6">
                 {{-- Procurement Method: {{$internalRequisition->procurement_method->name}}</br>
                 Commitment: {{$internalRequisition->commitment_no}}</br>
                 Category: {{$internalRequisition->category->name}} </br>
                 TRN: {{$internalRequisition->trn}}</br>
                 Estimate Cost: {{$internalRequisition->estimated_cost}} </br>
                 Cost Variance: {{$internalRequisition->cost_variance}} </br>
                 Date Last Order: {{$internalRequisition->date_last_ordered}} </br>
                  --}}

                 </div>
                 </div>
                 </p> 
                 <p>
                
                 </p>
                   
   <div class="col-m-12">
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

   <div class="row">
     <div class="col-sm-6">
       <!-- textarea -->
       <div class="form-group">
         <label>Comments/Justification</label>
       <textarea  readonly class="form-control" name="comments" rows="3" placeholder="{{$internalRequisition->comments}}"></textarea>
       </div>
     </div>
     
   </div>        
</div>




     
         <br>
   <br>
 

             
         

                 <div class="col-12">
                 <div class="form-group row">
                  
                   <div class="col-sm-6">
                     @if($internalRequisition->approve_internal_requisition)
                     Approved by: <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->user->firstname[0]}}. {{$internalRequisition->approve_internal_requisition->user->lastname}} </span></br>
                     Date:  <span class='badge badge-success'>{{$internalRequisition->approve_internal_requisition->created_at}}</span>
                     @else
                       Approve  by: <span class='badge badge-success'></span>
                       @endif
                   </div>

                   
                   <div class="col-sm-5">
                 @if($internalRequisition->approve_budget)
                 Budget Approve by: <span class='badge badge-success'>{{$internalRequisition->approve_budget->user->abbrName()}} </span></br>
                 Date:  <span class='badge badge-success'>{{$internalRequisition->approve_budget->created_at}}</span>
                 @else
                 Budget Approve by: <span class='badge badge-success'></span>
                   @endif
                   </div>
                 </div>
               </div>

  </div>
</body>
</body>
</html>