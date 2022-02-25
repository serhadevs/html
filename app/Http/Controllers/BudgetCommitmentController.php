<?php

namespace App\Http\Controllers;

use App\BudgetCommitment;
use App\ApproveBudget;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\User;
use App\Status;
use App\Comment;
use App\Notifications\BugetCommitmentPublish ;
use App\Notifications\ApproveBudgetPublish;
use App\Notifications\RefuseInternalRequisitionPublish;





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

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,7,8,14])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
     
        if (auth()->user()->institution_id === 0) {
            $internalrequisitions = InternalRequisition::with(['user','approve_internal_requisition','budget_commitment','institution','department','requisition_type'])
            ->whereHas('approve_internal_requisition',function($query){
             $query->where('is_granted','=', 1);
            })
            ->latest()
            ->get();

        }else{
       $internalrequisitions = InternalRequisition::with(['user','approve_internal_requisition','budget_commitment','institution','department','requisition_type'])
       ->whereHas('approve_internal_requisition',function($query){
        $query->where('is_granted','=', 1);
       })
          ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
       ->latest()
       ->get();
    }


    //    $internalcomplete = InternalRequisition::with(['approve_internal_requisition','budget_commitment'])
    //    ->whereHas('approve_internal_requisition',function($query){
    //     $query->where('is_granted','=', 1);
    //    })

    //    ->has('budget_commitment')
    //    ->get();

        //$budgetCommitment = BudgetCommitment::all();


       
       return view('/panel.account.budget.index',compact('internalrequisitions'));
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
       // dd($request->all());
        $request->validate([
            // 'commitment_no' => 'required',
            'budget_option' => 'required',
        ]);
        if($request->budget_option ==1)
        {
        $commitment = new BudgetCommitment();
        $commitment->internal_requisition_id = $request->id;
        $commitment->account_code = $request->account_code;
        $commitment->commitment_no = $request->commitment_no;
        $commitment->comment=$request->comments;
        $commitment->user_id = auth()->user()->id;
        $commitment->budget_option = $request->budget_option;
        $commitment->save();

        $status = Status::where('internal_requisition_id',$request->id)->first();
        $status->name = 'Budget Commitment';
        $status->update();

        $users = User::where('institution_id',auth()->user()->institution_id )
                ->whereIn('role_id',[8])
                ->get();
      // notify primary institution users
                $internalRequisition = InternalRequisition::find($request->id);
            
                $users->each->notify(new BugetCommitmentPublish($internalRequisition));
                //subscribe user institution notification
                $sub_users = User::users_in_institution($internalRequisition->institution_id)->whereIn('role_id',[8]);
                $sub_users->each->notify(new BugetCommitmentPublish($internalRequisition));

        // automatic authorization or apporval budget commitment
        if(in_array(auth()->user()->role_id, [1,8,14]))
        {
            $approve = new ApproveBudget();
            $permission = 1;
            $approve->internal_requisition_id = $commitment->internal_requisition_id;
            $approve->user_id = auth()->user()->id;
            $approve->is_granted = $permission ;
            $approve->save();
                //update requisition status
                $status = Status::where('internal_requisition_id',$commitment->internal_requisition_id)->first();
                $status->name = 'Budget Approve';
                $status->update();

                //notify procurement department
                $users = User::where('institution_id',auth()->user()->institution_id )
                // ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',[9,12])
                ->get();
      
                $internalRequisition = InternalRequisition::find($commitment->internal_requisition_id);
            
                $users->each->notify(new ApproveBudgetPublish($internalRequisition));


        }

    }else{

        $commitment = new BudgetCommitment();
        $commitment->internal_requisition_id = $request->id;
        $commitment->account_code = "";
        $commitment->commitment_no ="";
        $commitment->comment=$request->comments;
        $commitment->user_id = auth()->user()->id;
        $commitment->budget_option = $request->budget_option;
        $commitment->save();

        if(auth()->user()->role_id == 7)
        {
        // notify primary institution users
        $internalRequisition = InternalRequisition::find($request->id);
            
        $users->each->notify(new BugetCommitmentPublish($internalRequisition));
        //subscribe user institution notification
        $sub_users = User::users_in_institution($internalRequisition->institution_id)->whereIn('role_id',[8]);
        $sub_users->each->notify(new BugetCommitmentPublish($internalRequisition));
        }

         //update requisition status and add comments
         $comment = new Comment();
         $comment->internal_requisition_id = $commitment->internal_requisition_id ;
         $comment->type ='budget refuse';
         $comment->user_id = auth()->user()->id;
         $comment->comment =  $request->refuse_comment;
         $comment->save();

         

         
         $internalrequisition = internalrequisition::find($commitment->internal_requisition_id);
         $user = User::find($internalrequisition->user_id);
         $user->notify(new RefuseInternalRequisitionPublish($internalrequisition,$comment));
      //  $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ));
         $status = Status::where('internal_requisition_id',$commitment->internal_requisition_id)->first();
         $status->name = 'Budget commitment rejected';
         $status->update();
         
        //if budget manager
        if(in_array(auth()->user()->role_id, [1,8,14]))
        {
            $approve = new ApproveBudget();
            $permission = 0;
            $approve->internal_requisition_id = $commitment->internal_requisition_id;
            $approve->user_id = auth()->user()->id;
            $approve->is_granted = $permission ;
            $approve->save();
                //update requisition status and add comments
                // $comment = new Comment();
                // $comment->internal_requisition_id = $commitment->internal_requisition_id ;
                // $comment->type ='budget refuse';
                // $comment->user_id = auth()->user()->id;
                // $comment->comment =  $request->refuse_comment;
                // $comment->save();

                

                
                //$internalrequisition = internalrequisition::find($commitment->internal_requisition_id);
             //   $user = User::find($internalrequisition->user_id);
              //  $user->notify(new RefuseInternalRequisitionPublish($internalrequisition,$comment));
             //  $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ));
                $status = Status::where('internal_requisition_id',$commitment->internal_requisition_id)->first();
                $status->name = 'Budget rejected';
                $status->update();


        }




        }
         


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
    
        if ($budgetCommitment->internalrequisition->approve_budget) {
            if($budgetCommitment->internalrequisition->approve_budget->is_granted===1)
            return redirect('/budgetcommitment')->with('error', ' ' . $budgetCommitment->internalrequisition->requisition_no . ' is already approved.');
        }
        return view('/panel.account.budget.edit',compact('budgetCommitment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
       // dd($request->all());
        $budgetCommitment = BudgetCommitment::find($id);
        if($request->budget_option == 1){
        $budgetCommitment->account_code=$request->account_code;
        $budgetCommitment->commitment_no=$request->commitment_no;
        $budgetCommitment->budget_option = $request->budget_option;
        $budgetCommitment->update();
        }else{
        $budgetCommitment->account_code = "";
        $budgetCommitment->commitment_no ="";
        $budgetCommitment->user_id = auth()->user()->id;
        $budgetCommitment->budget_option = $request->budget_option;
        $budgetCommitment->update();



        }
      
        return redirect('/budgetcommitment')->with('status', 'Budget Commitment was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BudgetCommitment  $budgetCommitment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $budgetCommitment = BudgetCommitment::find($id);
            if ($budgetCommitment->internalrequisition->approve_budget) {
                if($budgetCommitment->internalrequisition->approve_budget->is_granted===1)
                return 'fail';
            }
            $budgetCommitment->delete();
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }
    }
}
