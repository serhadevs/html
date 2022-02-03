<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternalRequisition;
use App\Requisition;
use Carbon\Carbon;
use DB;

class GeneralReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
        $modules = Collect([

           
            [
                'id' => '1',
                'name' => 'Internalrequisition',
                'type' => 'App\InternalRequisition',
        
            ],
            // [
            //     'id' => '2',
            //     'name' => 'CertifiedInternalRequisition',
            //     'type' => 'App\CertifiedInternalRequisitio',
            // ],
            // [
            //     'id' => '3',
            //     'name' => 'ApproveInternalRequisition',
            //     'type' => 'App\ApproveInternalRequisition',
            // ],
            // [
            //     'id' => '4',
            //     'name' => 'BudgetCommitment',
            //     'type' => 'App\BudgetCommitment',
            // ],
            // [
            //     'id' => '5',
            //     'name' => 'ApproveBudget',
            //     'type' => 'App\ApproveBudget',
        
            // ],
            [
                'id' => '6',
                'name' => 'Requisition',
                'type' => 'App\Requisition',
            ],
            // [
            //     'id' => '7',
            //     'name' => 'Accept',
            //     'type' => 'App\Check',
            // ],
         
        
        ]);


 return view('/panel.reports.general-report.index',compact('modules'));
    //return view('/panel.audit.trail_ipr.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        dd("create");

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
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $module = $request->module_type;
      
       
        
        if($module == 1){
       $report = InternalRequisition:: whereBetween('created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
         })->get();
         dd(1);

        }else if($module == 3){
            $report = InternalRequisition::with(['approve_internal_requisition'])
        ->whereBetween('created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
        ->whereHas('approve_internal_requisition')
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
         })
        ->get();


        }else if($module == 6)
        {
            $report = Requisition::with(['check', 'approve','internalrequisition','department','institution','purchaseOrder','category','approve','supplier'])
               // ->where('contract_sum', '>=', 500000)
               ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
                ->latest()
                ->get();
              
               

        }
       
    //    $internal_requisitions = DB::table('internal_requisitions')
    //    ->leftJoin('departments','departments.id','=','internal_requisitions.department_id')
    //    ->leftJoin('institutions','institutions.id','=','internal_requisitions.institution_id')
    //    ->leftJoin('statuses','statuses.internal_requisition_id','=','internal_requisitions.id')
    //    ->leftJoin('requisition_types','requisition_types.id','=','internal_requisitions.requisition_type_id')
    //    ->leftJoin('requisition_types','requisition_types.id','=','internal_requisitions.requisition_type_id')
    //    ->leftJoin('users','user.id','=','internal_requisitions.user_id')
    //     ->select('requisitions.*,requisitiontypes.name as requisition_type')
    //    ->get();
       
        return view('/panel.reports.general-report.create', compact('report','module'));
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

        dd("show");
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
