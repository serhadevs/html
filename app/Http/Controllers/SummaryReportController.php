<?php

namespace App\Http\Controllers;

use App\SummaryReport;
use Illuminate\Http\Request;
use App\Institution;
use Carbon\Carbon;
use DB;

class SummaryReportController extends Controller
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
            if (in_array(auth()->user()->role_id, [1,2,3,5,6,9,10,11,12,14,15]) OR in_array(5,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            }else if(auth()->user()->institution_id ===0)
            {   
                return redirect('/dashboard')->with('error', 'Access Denied');

            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
            }
        });
    }
    public function index()
    {
        //
        $institutions = Institution::all();
        return view('/panel.reports.summary-report.index',compact('institutions'));
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

          $start_date = Carbon::parse($request->start_date);
          $end_date = Carbon::parse($request->end_date);
          $module_type = (int)$request->module_type;
        //  dd($request->institution_id);
          if($module_type === 1){
  
            $spend_by_parish= DB::table('requisitions')
            ->join('institutions','institutions.id','=','requisitions.institution_id')
            ->join('parishes','parishes.id','=','institutions.parish_id')
            ->select(
                
                    DB::raw('sum(contract_sum) as sums'),'parishes.name as parish',
                    DB::raw('count(contract_sum) as count'),
                   )
                   ->where('requisitions.deleted_at',null)
 // ->whereYear('requisitions.created_at', '=', 2021)
  ->groupBy('parish')
 // ->where('institutions.id','=',$request->institution_id)
   ->where(function($query) use($request){
       if($request->institution_id !=0){
           return  $query->where('institutions.id','=',$request->institution_id);
       }
       
   })
  ->orderBy('sums', 'DESC')
   ->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
  ->get();
     
  
      
  
  
      }else{
  
        $spend_by_parish= DB::table('requisitions')
        ->join('institutions','institutions.id','=','requisitions.institution_id')
        ->join('parishes','parishes.id','=','institutions.parish_id')
        ->join('purchase_orders','purchase_orders.requisition_id','=','requisitions.id')
    
        ->select(
            
                DB::raw('sum(contract_sum) as sums'),'parishes.name as parish',
                DB::raw('count(contract_sum) as count'),
                // DB::raw("DATE_FORMAT(requisitions.created_at,'%M') as months"),
                // DB::raw('YEAR(requisitions.created_at) year '),
                // DB::raw('MONTH(requisitions.created_at) month ')
               )
               ->where('requisitions.deleted_at',null)
// ->whereYear('requisitions.created_at', '=', 2021)
->groupBy('parish')
// ->where('parishes.id','=',auth()->user()->institution->parish->id)
->orderBy('sums', 'DESC')
->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
->where(function($query) use($request){
        if($request->institution_id !=0){
            return  $query->where('institutions.id','=',$request->institution_id);
        }
        
    })
->get();
  
  
 }
  
  //$start_date->format('d-M-Y');
   $total_sum =  $spend_by_parish->sum('sums');
   $total_count =  $spend_by_parish->sum('count');
  

      
          return view('/panel.reports.summary-report.create',compact('spend_by_parish','module_type','start_date','end_date','total_sum','total_count'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SummaryReport  $summaryReport
     * @return \Illuminate\Http\Response
     */
    public function show(SummaryReport $summaryReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SummaryReport  $summaryReport
     * @return \Illuminate\Http\Response
     */
    public function edit(SummaryReport $summaryReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SummaryReport  $summaryReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SummaryReport $summaryReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SummaryReport  $summaryReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(SummaryReport $summaryReport)
    {
        //
    }
}
