<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternalRequisition;
use App\Stock;
use App\UnitOfMeasurement;
use App\ApproveInternalRequisition;
use App\Notifications\InternalRequisitionApprovePublish;
use App\User;

class ApproveInternalRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2,3,12,10,11,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //

       // dd('arrived');
      $internalRequisitions = InternalRequisition::all()
    ->where('department_id', auth()->user()->department_id)
    ->where('institution_id', auth()->user()->institution_id);


    

        return view('/panel/approve/internal-requisition.index',compact('internalRequisitions'));

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
        //
        try {
            if ($request->all()) {
                $approve = new ApproveInternalRequisition();
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = true;
                $approve->save();

                $users = User::where('institution_id',auth()->user()->institution_id )
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',['1,2'])
                ->get();
      
                $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
            
                $users->each->notify(new InternalRequisitionApprovePublish($internalRequisition));

               
            }
            return 'success';
        
        } catch (Exception $e) {
            return 'fail';
        }

        return redirect('/panel/approve/internal-requisition.index')->with('status', 'Requisition was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
          $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
        //  dd( $internalRequisition);
        return view('/panel/approve/internal-requisition.show', compact('internalRequisition'));

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
