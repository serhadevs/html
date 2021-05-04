<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisition;
use App\PurchaseOrder;
use App\User;
use App\ Department;
use App\ Notification;
use App\Charts\ParishChart;
use App\Charts\DataChart;
use DB;



class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $requisitions= Requisition::where('institution_id', '=', auth()->user()->institution_id)->count();
      $purchase_Orders = PurchaseOrder::with(['requisition'])
      ->whereHas('requisition', function ($query) {
      $query->where('institution_id', '=', auth()->user()->institution_id);
            })
      ->count();
      $users = User::where('institution_id', '=', auth()->user()->institution_id)->count();
      $departments =  Department::count();

    


    $spend_by_parish= DB::table('requisitions')
              ->leftJoin('institutions','institutions.id','=','requisitions.institution_id')
              ->leftJoin('parishes','parishes.id','=','institutions.parish_id')
              ->select(
                  
                      DB::raw('sum(contract_sum) as sums'),'parishes.name as parish'
                      // DB::raw("DATE_FORMAT(requisitions.created_at,'%M') as months"),
                      // DB::raw('YEAR(requisitions.created_at) year '),
                      // DB::raw('MONTH(requisitions.created_at) month ')
                     )
    ->whereYear('requisitions.created_at', '=', 2021)
    ->groupBy('parish')
    // ->where('parishes.id','=',auth()->user()->institution->parish->id)
    
    ->get();
      $chart = new  DataChart;
      $chart -> labels( $spend_by_parish->pluck('parish'));
      $chart->dataset(' Spend by Parish','bar', $spend_by_parish->pluck('sums'))
      ->backgroundColor('red');



      //spend by category

      $spend_by_category = DB::table('requisitions')
    // ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    // ->leftJoin('parishes', 'parishes.id', '=', 'institutions.parish_id')
    ->leftJoin('stock_categories','stock_categories.id','=','requisitions.category_id')
    ->select('stock_categories.name as categoryname', DB::raw('sum(contract_sum) as sums'))   
    // ->where('parishes.id', '=', auth()->user()->institution->parish->id)
    ->groupBy('requisitions.category_id','categoryname')
    ->get();
  
      $chart2 = new DataChart;
      $chart2->labels($spend_by_category->pluck('categoryname'));
      $chart2->dataset(' Spend By Category', 'horizontalBar', $spend_by_category->pluck('sums'))
    ->backgroundColor('blue');


    //Spend by institution
      $spend_by_institution = DB::table('requisitions')
    ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    ->leftJoin('parishes', 'parishes.id', '=', 'institutions.parish_id')
    ->select(

        DB::raw('sum(contract_sum) as sums'), 'institutions.name as institution'
        
    )
    ->whereYear('requisitions.created_at', '=', 2021)
    ->groupBy('institution')
    
// ->where('parishes.id','=',auth()->user()->institution->parish->id)

    ->get();
    //dd($spend_by_institution);

    $chart3 = new DataChart;
    $chart3->labels($spend_by_institution->pluck('institution'));
    $chart3->dataset(' Spend by Institution', 'bar',$spend_by_institution->pluck('sums'))
        ->backgroundColor('gold');


      $internalrequisition =  Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionPublish')->get();
      $internalRequisitionApprove =  Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionApprovePublish')->get();
   

     $alerts = Notification::where('notifiable_id',auth()->user()->id)->get();
    //   $alerts = DB::table('notifications')
    //   ->where('data->user_id',auth()->user()->id)
    //   // ->select('data->requisition_no as num ','created_at' ,'type')
    //  // ->select(\DB::raw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.requisition_no')) as num"),'type','created_at')
    //   ->select('data','type','created_at')
    //   ->get();
     //dd($alerts[0]->type);
            
        return view('panel.dashboard.index',['alerts'=>$alerts,'internalrequisition'=>$internalrequisition,'chart'=>$chart,'chart2'=>$chart2,'chart3'=>$chart3,'requisitions'=>$requisitions,'purchase_Orders'=>$purchase_Orders,'user'=>$users,'departments'=>$departments]);
    }
}

// JSON_VALUE(@data,'$.employees') AS 'Result'
//Package::whereJsonContains('destinations',["Goa"])->get();