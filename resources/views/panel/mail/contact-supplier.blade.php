@component('mail::message')




This is to notify you that your bid, for the execution of the {{$purchaseOrder->requisition->description}}, at the {{$purchaseOrder->requisition->internalrequisition->institution->name}}.
The Accepted Contract Amount of ${{number_format($purchaseOrder->requisition->contract_sum,)}}, as corrected and modified in accordance with the Instructions to Bidders, 
is hereby accepted by South-East Regional Health Authority.

{{$purchaseOrder->user->fullName()}}<br>
{{$purchaseOrder->user->role->name}}<br>


Telephone:{{$purchaseOrder->user->telephone}}<br>
Email:{{$purchaseOrder->user->email}}<br>
Location:{{$purchaseOrder->user->institution->name}}<br>



<hr></hr>
Please do not reply to this e-mail as it is sent from a notification only address and cannot accept incoming emails. 

@endcomponent