<?php

namespace App\Http\Controllers;

use App\BudgetCommitment;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\BugetCommitmentPublish ;


class BudgetCommitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function __construct(Request $request)
    {

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,7,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
       // dd('bugetcommitment');
       $internalrequisitions = InternalRequisition::with(['approve_internal_requisition','budget_commitment'])
       ->whereHas('approve_internal_requisition',function($query){
        $query->where('is_granted','=', 1);
       })

       ->doesnthave('budget_commitment')
       ->get();



       $internalcomplete = InternalRequisition::with(['approve_internal_requisition','budget_commitment'])
       ->whereHas('approve_internal_requisition',function($query){
        $query->where('is_granted','=', 1);
       })

       ->has('budget_commitment')
       ->get();


       
       return view('/panel.account.budget.index',compact('internalrequisitions','internalcomplete'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        //dd($id);
        $internalrequisition = InternalRequisition::find($id);
        return view('/panel.account.budget.create',compact('internalrequisition'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'commitment_no' => 'required',
            'account_code' => 'required',
        ]);
        $commitment = new BudgetCommitment();
        $commitment->internal_requisition_id = $request->id;
        $commitment->account_code = $request->account_code;
        $commitment->commitment_no = $request->commitment_no;
        $commitment->comment=$request->comments;
        $commitment->user_id = auth()->user()->id;
        $commitment->save();

        $users = User::where('institution_id',auth()->user()->institution_id )
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',[1,5,2])
                ->get();
      
                $internalRequisition = InternalRequisition::find($request->id);
            
                $users->each->notify(new BugetCommitmentPublish($internalRequisition));
         


        return redirect('/budgetcommitment')->with('status', 'Budget was commited  successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetCommitment $budgetCommitment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budgetCommitment = BudgetCommitment::find($id);
      // dd($budgetCommitment->internalrequisition);
        return view('/panel.account.budget.edit',compact('budgetCommitment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetCommitment $budgetCommitment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetCommitment $budgetCommitment)
    {
        //
    }
}
