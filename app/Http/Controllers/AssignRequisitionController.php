<?php

namespace App\Http\Controllers;

use App\AssignRequisition;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\RequisitionType;
use App\User;

class AssignRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $internal_requisitions = InternalRequisition::with(['assignto','approve_internal_requisition','budget_commitment'])
        ->whereHas('approve_internal_requisition',function($query){
         $query->where('is_granted','=', 1);
        })
 
        ->has('budget_commitment')
        ->doesnthave('assignto')
        ->get();

        return view('/panel.assign.index',compact('internal_requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
       // dd(auth()->user()->institution_id);
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
        $users = User::whereIn('role_id',[5,9])
        ->where('institution_id','=',auth()->user()->institution->id)
        ->get();
         
        if ($internalRequisition->assignto) {
            return redirect('/assign_requisition')->with('error', 'The Internal Requisition is already assign to'.' ' . $internalRequisition->assignto->user->lastname);
        }
        return view('/panel.assign.create',compact('internalRequisition','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       // dd($request->all());
       $assignee = new AssignRequisition();
       $assignee->user_id = $request->user_id;
       $assignee->internal_requisition_id = $request->requisition_id;
       //send email to assigned task
       $assignee->save();


       return redirect('/assign_requisition')->with('status', 'The internal requisition was assign to procurement officer successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function show(AssignRequisition $assignRequisition)
    {
        dd('test');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
        $users = User::all();  
        return view('/panel.assign.edit',compact('internalRequisition','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignRequisition $assignRequisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignRequisition $assignRequisition)
    {
        //
    }
}
