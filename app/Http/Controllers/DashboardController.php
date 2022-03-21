<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisition;
use App\InternalRequisition;
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
          $this->middleware('password.expired');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
  
      if(auth()->user()->institution_id ===0 AND in_array(auth()->user()->role_id,[1,12])){
        $internalrequisitions= InternalRequisition::count();

        $tendering = InternalRequisition::with('approve_budget')
        ->whereHas('approve_budget',function($query){
          $query->where('is_granted',1)->where('deleted_at',null);
        })
        ->count();
       
        $requisitions= Requisition::count();
        
        $purchase_Orders = PurchaseOrder::with(['requisition'])
        ->whereHas('requisition')
        
        ->count();
              
        $internal_requisition_sum = InternalRequisition::sum('estimated_cost'); 
        $tendering_sum = InternalRequisition::with('approve_budget')->whereHas('approve_budget',function($query){
          $query->where('is_granted',1)->where('deleted_at',null);
        })->sum('estimated_cost');
        $requisition_sum = Requisition::sum('contract_sum'); 
        $purchase_Orders_sum = DB::table('purchase_orders')
        ->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
        ->select('contract_sum')
        ->sum(DB::raw('requisitions.contract_sum'));
    
        //$users = User::count();

      }elseif(auth()->user()->institution_id ===0 AND !in_array(auth()->user()->role_id,[1,12])){
        $internalrequisitions= InternalRequisition::where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
  
       })->count();
       
        $requisitions= Requisition::where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
  
       })
        ->count();

        $purchase_Orders = PurchaseOrder::with(['requisition'])
        ->whereHas('requisition', function ($query) {
        $query->where('institution_id', '=', auth()->user()->institution_id)
        ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
              })
        ->count();

        $tendering = InternalRequisition::with('approve_budget')
        ->whereHas('approve_budget',function($query){
          $query->where('is_granted',1)->where('deleted_at',null);
        })
        ->where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
         })->count();
        
  
  
        $internal_requisition_sum = InternalRequisition::where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
       })->sum('estimated_cost'); 

        $tendering_sum = InternalRequisition::with('approve_budget')
        ->whereHas('approve_budget',function($query){
          $query->where('is_granted',1)->where('deleted_at',null);
        })->where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
       })->sum('estimated_cost');

        $requisition_sum = Requisition::where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
       })->sum('contract_sum'); 
        
        $purchase_Orders_sum = DB::table('purchase_orders')
        ->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
        ->select('contract_sum')
        ->where(function($query){
          $query->where('institution_id','=',auth()->user()->institution_id)
          ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
       })->sum(DB::raw('requisitions.contract_sum'));


      }else{

        
      $internalrequisitions= InternalRequisition::where('institution_id', '=', auth()->user()->institution_id)->count();
      $requisitions= Requisition::where('institution_id', '=', auth()->user()->institution_id)->count();
      $purchase_Orders = PurchaseOrder::with(['requisition'])
      ->whereHas('requisition', function ($query) {
      $query->where('institution_id', '=', auth()->user()->institution_id);
            })
      ->count();
      $tendering = InternalRequisition::with('approve_budget')
      ->whereHas('approve_budget',function($query){
        $query->where('is_granted',1)->where('deleted_at',null);
      })
      ->where('institution_id', '=', auth()->user()->institution_id)
      ->count();
      // $users = User::where('institution_id', '=', auth()->user()->institution_id)->count();

      $internal_requisition_sum = InternalRequisition::where('institution_id', '=', auth()->user()->institution_id)->sum('estimated_cost'); 
      $tendering_sum = InternalRequisition::with('approve_budget')->whereHas('approve_budget',function($query){
        $query->where('is_granted',1)->where('deleted_at',null);
      })
      ->where('institution_id', '=', auth()->user()->institution_id)
      ->sum('estimated_cost');
      $requisition_sum = Requisition::where('institution_id', '=', auth()->user()->institution_id)->sum('contract_sum'); 
      $purchase_Orders_sum = DB::table('purchase_orders')
      ->join('requisitions','requisitions.id','=','purchase_orders.requisition_id')
      ->select('contract_sum')
      ->where('institution_id', '=', auth()->user()->institution_id)
      ->sum(DB::raw('requisitions.contract_sum'));

      
          }
    


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
    // ->where('parishes.id','=',auth()->user()->institution->parish->id)
    ->orderBy('sums', 'DESC')
    ->get();

    
      $chart = new  DataChart;
      $chart -> labels( $spend_by_parish->pluck('parish'));
      $chart->dataset(' Spend by Parish','bar', $spend_by_parish->pluck('sums'))
      ->backgroundColor('red');



      //spend by category

      $spend_by_category = DB::table('requisitions')
    // ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
    // ->leftJoin('parishes', 'parishes.id', '=', 'institutions.parish_id')
    ->join('stock_categories','stock_categories.id','=','requisitions.category_id')
    ->select('stock_categories.name as categoryname', DB::raw('sum(contract_sum) as sums'))   
    // ->where('parishes.id', '=', auth()->user()->institution->parish->id)
    ->groupBy('requisitions.category_id','categoryname')
    ->where('requisitions.deleted_at',null)
    ->orderBy('sums', 'DESC')
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
    ->select(

        DB::raw('sum(contract_sum) as sums'), 'institutions.abbr as institution'
        
    )
    //->whereYear('requisitions.created_at', '=', 2021)
    ->groupBy('institution','requisitions.institution_id')
    
// ->where('parishes.id','=',auth()->user()->institution->parish->id)

    ->get();
    //dd($spend_by_institution);


    //assignto
    $assign_internal_requisitions = InternalRequisition::with(['assignto', 'approve_internal_requisition', 'budget_commitment', 'approve_budget','requisition'])
    ->whereHas('approve_internal_requisition', function ($query) {
        $query->where('is_granted', '=', 1);
    })
    ->whereHas('assignto', function ($query) {
        $query->where('user_id', '=', auth()->user()->id);
    })
    ->has('approve_budget')
  ->doesnthave('requisition')
    ->get();
    // dd(auth()->user()->assignTo->isEmpty());

    $chart3 = new DataChart;
    $chart3->labels($spend_by_institution->pluck('institution'));
    $chart3->dataset(' Spend by Institution', 'bar',$spend_by_institution->pluck('sums'))
    ->backgroundColor('gold');
  

      $internalrequisition =  Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionPublish')->get();
      $internalRequisitionApprove =  Notification::where('notifiable_id',auth()->user()->id)->where('type','App\Notifications\InternalRequisitionApprovePublish')->get();
           
        return view('panel.dashboard.index',['purchase_Orders_sum'=> $purchase_Orders_sum,'requisition_sum'=>$requisition_sum,'tendering'=> $tendering,'tendering_sum' => $tendering_sum,'internal_requisition_sum'=>$internal_requisition_sum,'assign_internal_requisitions'=>$assign_internal_requisitions,'internalrequisition'=>$internalrequisition,'chart'=>$chart,'chart2'=>$chart2,'chart3'=>$chart3,'requisitions'=>$requisitions,'purchase_Orders'=>$purchase_Orders,'internalrequisitions'=> $internalrequisitions]);
    }

    public function markAsRead($id)
    {
     $notification = Notification::find($id);
     // dd($id);
     //auth()->user()->unreadNotifications->where('id',$id)->markAsRead();

    DB::table('notifications')->where('id',$id)->update(['read_at'=>1]);

    return redirect('/dashboard')->with('status', 'Remove notification successfully');
    }


}

// JSON_VALUE(@data,'$.employees') AS 'Result'
//Package::whereJsonContains('destinations',["Goa"])->get();


