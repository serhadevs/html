<?php

namespace App\Http\Controllers;

use App\ProcurementCommittee;
use Illuminate\Http\Request;
use App\Approve;
use App\PurchaseOrder;
use App\Requisition;
use App\InternalRequisition;
use DB;
use App\User;
use App\Status;
use App\ CommitteeMember;
use App\MeetingType;
use App\ActionTaken;

class ProcurementCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (in_array(auth()->user()->role_id, [1,5,9,12,15]) OR in_array(5,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard');
            }
        });
    }
    public function index()
    {
        //
        $requisitions = Requisition::with(['check','approve','purchaseOrder'])
        ->withCount('approve')
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
        ->whereHas('check', function ($query) {
            $query->where('is_checked', '=', 1);
        })
        ->whereHas('approve', function ($query) {
            $query->where('is_granted', '=', 1);
        })
        ->doesnthave('purchaseOrder')
        ->where('contract_sum','>',1500000)
        ->having('approve_count','>=',1)
        // ->where(function($query){
        //     if(auth()->user()->institution_id ===1){
        //      $query->having('approve_count','>',1);
        //     }else{
        //      $query->having('approve_count','>',2);
        //     }
         
        // })
        ->latest()
        ->get();

       
        return view('/panel.procurement-committee.index',(compact('requisitions')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $requisition = Requisition::find($id);
       return view('/panel.procurement-committee.create',compact('requisition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $request->validate([
            'meeting_type_id' => 'required',
            'submission' => 'required',
            'action_taken_id' => 'required',
            'name'=>'required',
            'decision'=>'required',
            'date'=>'required',
            'signature'=>'required',
            

        ]);
       // dd($request->all());
        $committee = new ProcurementCommittee();
        $committee->meeting_type_id = $request->meeting_type_id;
        $committee->location = $request->location;
        $committee->date_submission=$request->submission;
        $committee->date_last_signatory=$request->signatory;
        $committee->requisition_id =$request->id;
        $committee->action_taken_id = $request->action_taken_id;
        if($committee->save())
        {
            if ($request['name'][0]) {
                foreach ($request['name'] as $key => $member) {
                    $stock = CommitteeMember::create([
                        'name' => $request['name'][$key],
                        'decision' => $request['decision'][$key],
                        'signature' => $request['signature'][$key],
                        'date' => $request['date'][$key],  
                        'procurement_committee_id' => $committee->id ,                          
                    ]);
                
                }

            }
            $requisition::find($request->id);
            $comment = new Comment();
            $comment->internal_requisition_id = $requisition->internal_requisition_id;
            $comment->type ='refuse';
            $comment->user_id = auth()->user()->id;
            $comment->comment =  $request->data['comment'];
            $comment->save();

        }
        return redirect('/procurement-committee')->with('status', 'Procuremmet committee was created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcurementCommittee  $procurementCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(ProcurementCommittee $procurementCommittee)
    {
        //
      //  dd('test');
  
      
        return view('/panel.procurement-committee.show', compact('procurementCommittee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcurementCommittee  $procurementCommittee
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcurementCommittee $procurementCommittee)
    {
        //
            $meet_types = MeetingType::all();
            $action_takens =ActionTaken:: all();
            if(isset($procurementCommittee->requisition->entity_head_approve)){
                if($procurementCommittee->requisition->entity_head_approve->is_granted ===1){
                    return redirect('/procurement-committee')->with('error', 'Requisition ' . $procurementCommittee->requisition->requisition_no . ' is already approved By Entity Head.');
                }
            }
        return view('/panel.procurement-committee.edit', compact('action_takens','meet_types','procurementCommittee'));
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcurementCommittee  $procurementCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcurementCommittee $procurementCommittee)
    {
        //dd($request->all());
        // $request->validate([
        //     'meeting_type_id' => 'required',
        //     'submission' => 'required',
        //     'action_taken_id' => 'required',
        //     'name'=>'required',
        //     'decision'=>'required',
        //     'date'=>'required',
        //     'signature'=>'required',
            

        // ]);
        $committee = ProcurementCommittee::find($procurementCommittee->id);
        $committee->meeting_type_id = $request->meeting_type_id;
        $committee->location = $request->location;
        $committee->date_submission=$request->submission;
        $committee->date_last_signatory=$request->signatory;
        $committee->action_taken_id = $request->action_taken_id;

      
        if($committee->update())
        {
            if($procurementCommittee->members){
            CommitteeMember::where('procurement_committee_id',  $committee->id)->delete();
            }
        
                foreach ($request['names'] as $key => $member) {
                     CommitteeMember::create([
                        'name' => $request['names'][$key],
                        'decision' => $request['decisions'][$key],
                        'signature' => $request['signatures'][$key],
                        'date' => $request['date'][$key],  
                        'procurement_committee_id' => $committee->id ,                          
                    ]);
                
                }

        
          
          
   
           
        }
        return redirect('/procurement-committee')->with('status', 'Procuremmet committee was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcurementCommittee  $procurementCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcurementCommittee $procurementCommittee)
    {
        //
    }
}
