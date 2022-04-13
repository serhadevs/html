<?php

namespace App\Http\Controllers;

use App\SpendAnalysis;
use Illuminate\Http\Request;
use DB;
use App\Charts\DataChart;
use Carbon\Carbon;
use App\Institution;

class SpendAnalysisController extends Controller
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
            if (in_array(auth()->user()->role_id, [1,2,3,5,6,9,10,11,12,14,15]) OR auth()->user()->department_id ===3 OR in_array(5,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
            }
        });
    }
    public function index()
    {
        //
        $institutions = Institution::all();
        return view('/panel.reports.spend-analysis.index',compact('institutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        dd('create');
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
        $module_type = (int)$request->module_type;
      //  dd($request->institution_id);
        if($module_type === 1){

          
        $spend_by_parish= DB::table('requisitions')
              ->join('institutions','institutions.id','=','requisitions.institution_id')
              ->join('parishes','parishes.id','=','institutions.parish_id')
              ->select(
                  
                      DB::raw('sum(contract_sum) as sums'),'parishes.abbr as parish'
                      // DB::raw("DATE_FORMAT(requisitions.created_at,'%M') as months"),
                      // DB::raw('YEAR(requisitions.created_at) year '),
                      // DB::raw('MONTH(requisitions.created_at) month ')
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

    
      $chart = new  DataChart;
      $chart -> labels( $spend_by_parish->pluck('parish'));
      $chart->dataset(' Spend by Parish','bar', $spend_by_parish->pluck('sums'))
      ->backgroundColor('red');



      //spend by category

      $spend_by_category = DB::table('requisitions')
      ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    // ->leftJoin('parishes', 'parishes.id', '=', 'institutions.parish_id')
    ->join('stock_categories','stock_categories.id','=','requisitions.category_id')
    ->select('stock_categories.name as categoryname', DB::raw('sum(contract_sum) as sums'))   
    // ->where('parishes.id', '=', auth()->user()->institution->parish->id)
    ->groupBy('requisitions.category_id','categoryname')
    ->where('requisitions.deleted_at',null)
    ->orderBy('sums', 'DESC')
    ->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
    ->where(function($query) use($request){
         if($request->institution_id !=0){
             return  $query->where('institutions.id','=',$request->institution_id);
         }
         
     })
    ->get();
  
      $chart2 = new DataChart;
      $chart2->labels($spend_by_category->pluck('categoryname'));
      $chart2->dataset(' Spend By Category', 'horizontalBar', $spend_by_category->pluck('sums'))
    ->backgroundColor('blue');


    //Spend by institution
      $spend_by_institution = DB::table('requisitions')
    ->join('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    ->join('parishes', 'parishes.id', '=', 'institutions.parish_id')
    ->where('requisitions.deleted_at',null)
    ->orderBy('sums', 'DESC')
    ->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
    ->select(

        DB::raw('sum(contract_sum) as sums'), 'institutions.abbr as institution'
        
    )
    //->whereYear('requisitions.created_at', '=', 2021)
    ->groupBy('institution','requisitions.institution_id')
    ->where(function($query) use($request){
        if($request->institution_id !=0){
            return  $query->where('institutions.id','=',$request->institution_id);
        }
        
    })

    ->get();
    $chart3 = new DataChart;
    $chart3->labels($spend_by_institution->pluck('institution'));
    $chart3->dataset(' Spend by Institution', 'bar',$spend_by_institution->pluck('sums'))
    ->backgroundColor('gold');

    //volume by supplier
    $valume_by_supplier = DB::table('requisitions')
    ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    // ->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
    ->join('suppliers','suppliers.id','=','requisitions.supplier_id')
    ->select(          
      DB::raw('Count(requisitions.id) as total'),'requisitions.supplier_id','suppliers.name as name')
     ->groupBy('requisitions.supplier_id','suppliers.name')
     ->orderBy('total', 'DESC')
     ->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
     ->where(function($query) use($request){
        if($request->institution_id !=0){
            return  $query->where('institutions.id','=',$request->institution_id);
        }
        
    })
     ->get();

    $chart4 = new DataChart;
    $chart4->labels(  $valume_by_supplier->pluck('name'));
    $chart4->dataset('Volume by suppliers', 'horizontalBar',$valume_by_supplier->pluck('total'))
    ->backgroundColor('orange');
    
    //spend to supplier
    $spend_by_supplier = DB::table('requisitions')
   // ->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
   ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    ->join('suppliers','suppliers.id','=','requisitions.supplier_id')
    ->select(          
      DB::raw('Sum(requisitions.contract_sum) as sum'),'requisitions.supplier_id','suppliers.name as name')
     ->groupBy('requisitions.supplier_id','suppliers.name')
     ->orderBy('sum', 'DESC')
     ->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
     ->where(function($query) use($request){
        if($request->institution_id !=0){
            return  $query->where('institutions.id','=',$request->institution_id);
        }
        
    })
     ->get();
    
    $chart5 = new DataChart;
    $chart5->labels(  $spend_by_supplier->pluck('name'));
    $chart5->dataset('Spend by suppliers', 'horizontalBar',$spend_by_supplier->pluck('sum'))
    ->backgroundColor('green');

    // if purchase order

    }else{

        $spend_by_parish= DB::table('requisitions')
        ->join('institutions','institutions.id','=','requisitions.institution_id')
        ->join('parishes','parishes.id','=','institutions.parish_id')
        ->join('purchase_orders','purchase_orders.requisition_id','=','requisitions.id')
    
        ->select(
            
                DB::raw('sum(contract_sum) as sums'),'parishes.abbr as parish'
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


$chart = new  DataChart;
$chart -> labels( $spend_by_parish->pluck('parish'));
$chart->dataset(' Spend by Parish','bar', $spend_by_parish->pluck('sums'))
->backgroundColor('red');



//spend by category

$spend_by_category = DB::table('requisitions')
->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
// ->leftJoin('parishes', 'parishes.id', '=', 'institutions.parish_id')
->join('stock_categories','stock_categories.id','=','requisitions.category_id')
->join('purchase_orders','purchase_orders.requisition_id','=','requisitions.id')
->select('stock_categories.name as categoryname', DB::raw('sum(contract_sum) as sums'))   
// ->where('parishes.id', '=', auth()->user()->institution->parish->id)
->groupBy('requisitions.category_id','categoryname')
->where('requisitions.deleted_at',null)
->orderBy('sums', 'DESC')
->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
->where(function($query) use($request){
    if($request->institution_id !=0){
        return  $query->where('institutions.id','=',$request->institution_id);
    }
    
})
->get();

$chart2 = new DataChart;
$chart2->labels($spend_by_category->pluck('categoryname'));
$chart2->dataset(' Spend By Category', 'horizontalBar', $spend_by_category->pluck('sums'))
->backgroundColor('blue');


//Spend by institution
$spend_by_institution = DB::table('requisitions')
->join('institutions', 'institutions.id', '=', 'requisitions.institution_id')
->join('parishes', 'parishes.id', '=', 'institutions.parish_id')
->join('purchase_orders','purchase_orders.requisition_id','=','requisitions.id')
->where('requisitions.deleted_at',null)
->orderBy('sums', 'DESC')
->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
->select(

  DB::raw('sum(contract_sum) as sums'), 'institutions.abbr as institution'
  
)
//->whereYear('requisitions.created_at', '=', 2021)
->groupBy('institution','requisitions.institution_id')

// ->where('parishes.id','=',auth()->user()->institution->parish->id)
->where(function($query) use($request){
    if($request->institution_id !=0){
        return  $query->where('institutions.id','=',$request->institution_id);
    }
    
})
->get();

$chart3 = new DataChart;
$chart3->labels($spend_by_institution->pluck('institution'));
$chart3->dataset(' Spend by Institution', 'bar',$spend_by_institution->pluck('sums'))
->backgroundColor('gold');

//volume by supplier
$valume_by_supplier = DB::table('purchase_orders')

->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
->join('institutions', 'institutions.id', '=', 'requisitions.institution_id')
->join('suppliers','suppliers.id','=','requisitions.supplier_id')
->select(          
DB::raw('Count(requisitions.id) as total'),'requisitions.supplier_id','suppliers.name as name')
->groupBy('requisitions.supplier_id','suppliers.name')
->orderBy('total', 'DESC')
->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
->where(function($query) use($request){
    if($request->institution_id !=0){
        return  $query->where('institutions.id','=',$request->institution_id);
    }
    
})
->get();

$chart4 = new DataChart;
$chart4->labels(  $valume_by_supplier->pluck('name'));
$chart4->dataset('Volume by suppliers', 'horizontalBar',$valume_by_supplier->pluck('total'))
->backgroundColor('orange');

//spend to supplier
$spend_by_supplier = DB::table('purchase_orders')
->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
->join('institutions', 'institutions.id', '=', 'requisitions.institution_id')
->join('suppliers','suppliers.id','=','requisitions.supplier_id')
->select(          
DB::raw('Sum(requisitions.contract_sum) as sum'),'requisitions.supplier_id','suppliers.name as name')
->groupBy('requisitions.supplier_id','suppliers.name')
->orderBy('sum', 'DESC')
->whereBetween('requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
->where(function($query) use($request){
    if($request->institution_id !=0){
        return  $query->where('institutions.id','=',$request->institution_id);
    }
    
})

->get();

$chart5 = new DataChart;
$chart5->labels(  $spend_by_supplier->pluck('name'));
$chart5->dataset('Spend by suppliers', 'horizontalBar',$spend_by_supplier->pluck('sum'))
->backgroundColor('green');






    }

    
        return view('/panel.reports.spend-analysis.create',compact('module_type','spend_by_parish','chart','spend_by_category','chart2', 'spend_by_institution','chart3','valume_by_supplier','chart4','spend_by_supplier','chart5'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpendAnalysis  $spendAnalysis
     * @return \Illuminate\Http\Response
     */
    public function show(SpendAnalysis $spendAnalysis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpendAnalysis  $spendAnalysis
     * @return \Illuminate\Http\Response
     */
    public function edit(SpendAnalysis $spendAnalysis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpendAnalysis  $spendAnalysis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpendAnalysis $spendAnalysis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpendAnalysis  $spendAnalysis
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpendAnalysis $spendAnalysis)
    {
        //
    }
}
