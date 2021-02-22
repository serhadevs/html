<?php

namespace App\Http\Controllers;

use App\ApproveBudget;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\Notifications\ApproveBudgetPublish;
use App\User;

class ApproveBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    
        $internalRequisitions = InternalRequisition::with(['approve_internal_requisition','budget_commitment'])
       ->whereHas('approve_internal_requisition',function($query){
        $query->where('is_granted','=', 1);
       })

       ->has('budget_commitment')
       ->get();

        return view('/panel/approve/budget.index',compact('internalRequisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->all()) {
                $approve = new ApproveBudget();
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = true;
                $approve->save();

                $users = User::where('institution_id',auth()->user()->institution_id )
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',['1,2,5'])
                ->get();
      
                $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
            
                $users->each->notify(new ApproveBudgetPublish($internalRequisition));

               
            }
            return 'success';
        
        } catch (Exception $e) {
            return 'fail';
        }

        return redirect('/panel/approve/internal-requisition.index')->with('status', 'Budget was approve successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         //
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
     
         return view('/panel/approve/budget.show', compact('internalRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function edit(ApproveBudget $approveBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApproveBudget $approveBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApproveBudget $approveBudget)
    {
        //
    }
}
