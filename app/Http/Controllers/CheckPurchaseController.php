<?php

namespace App\Http\Controllers;

use App\Check;
use App\Requisition;
use Illuminate\Http\Request;
// use App\Department;
// use App\Institution;
use DB;
// use App\Stock;
use App\Supplier;
// use App\StockCategory;
use App\InternalRequisition;
use App\User;
use App\Approve;
use App\Comment;
use App\Notifications\AcceptRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;


use App\UnitOfMeasurement;


class CheckPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Request $request)
    {

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,5,9,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }

    public function index()
    {

       
        //  $requisitions = Requisition::with(['check', 'approve', 'purchase_order'])
        // ->where('institution_id', '=', auth()->user()->institution_id)->get();
        if (auth()->user()->institution_id === 1) {
    $requisitions = Requisition::with(['check', 'approve', 'purchase_order'])
        ->where('contract_sum', '>=', 500000)
        ->Orwhere('institution_id', '=', auth()->user()->institution_id)
        ->get();

} else {
    $requisitions = Requisition::with(['check', 'approve', 'purchase_order'])
        ->where('institution_id', '=', auth()->user()->institution_id)
        ->where('contract_sum', '<', 500000)
        ->get();
}

    
                // $comment = new Comment();
                // $comment->check_id = 1;
                // $comment->type ='accept';
                // $comment->comment = 'this was a rest';
                // $comment->save();
               // dd($comment);
   
        return view('/panel.check-purchase.index', ['requisitions' => $requisitions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/panel.check-purchase.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $selected_items->data['appTypeId'];
   
        try {
            
                $requisition = Requisition::find($request->data['requisitionId']);
                $refuse =  $request->data['refuse'];
                $check = new Check();
                $check->is_check =  $request->data['check'];
                $check->is_refuse =  $refuse;
                // $check->check_date = now();
                $check->requisition_id = $request->data['requisitionId'];
                $check->user_id = auth()->user()->id;
                $check->save();
              
                if($refuse ==1){
                    $comment = new Comment();
                    $comment->internal_requisition_id =  $requisition->internal_requisition_id;
                    $comment->type ='refuse acceptance';
                    $comment->user_id = auth()->user()->id;
                    $comment->comment =  $request->data['comment'];
                    $comment->save();

                    
                    
                    $requisition = Requisition::find($request->data['requisitionId']);
                    $user = User::find($requisition->user_id);
                    $user->notify(new RefuseRequisitionPublish($requisition,$comment));
                   // $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ))

            

                }else{

            $requisition =  Requisition::find($request->data['requisitionId']);
            $requisition->institution_id  = auth()->user()->institution_id;
            $requisition->update();

            //delete or reset any approved requisition
            if($requisition->approve)
            {
                $approve = Approve::where('requisition_id',$requisition->id);
                $approve->delete();
             
            }

            $users = User::where('institution_id',auth()->user()->institution_id )
            ->where('department_id', auth()->user()->department_id)
            ->whereIn('role_id',[1,9,12])
            ->get();

                    $requisition = Requisition::find($request->data['requisitionId']);
                
                    $users->each->notify(new AcceptRequisitionPublish($requisition));
                }
        
           
            return 'success';

           
        } catch (Exception $e) {
            return 'fail';
        }
        return redirect('/requisition')->with('status', 'Requisition was created successfully');

    }

 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $internal_requisition_id = Requisition::find($id)->pluck('internal_requisition_id');
       // dd(  $internal_requisition_id);
        $requisition=  Requisition::with('internalrequisition')->find($id);
       
        
       //dd($requisitions);
        return view('/panel.check-purchase.show',compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
