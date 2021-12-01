<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class AuditTrailController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,3,12])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        //  $auditble_types = \OwenIt\Auditing\Models\Audit::groupBy('user_id')->distinct()->get();
$auditble_types = Collect([
    [
        'id' => '1',
        'name' => 'Internalrequisition',
        'type' => 'App\InternalRequisition',

    ],
    [
        'id' => '2',
        'name' => 'Requisition',
        'type' => 'App\Requisition',

    ],
    [
        'id' => '3',
        'name' => 'ApproveInternalRequisition',
        'type' => 'App\ApproveInternalRequisition',
    ],
    [
        'id' => '4',
        'name' => 'ApproveRequisition',
        'type' => 'App\Approve',
    ],
    [
        'id' => '5',
        'name' => 'ApproveBudget',
        'type' => 'App\ApproveBudget',
    ],
    [
        'id' => '6',
        'name' => 'BudgetCommitment',
        'type' => 'App\BudgetCommitment',
    ],
    [
        'id' => '7',
        'name' => 'CertifiedInternalRequisition',
        'type' => 'App\CertifiedInternalRequisitio',
    ],
    [
        'id' => '8',
        'name' => 'Accept',
        'type' => 'App\Check',
    ],
 
    [
        'id' => '9',
        'name' => 'Department',
        'type' => 'App\Department',
    ],
    [
        'id' => '10',
        'name' => 'Institution',
        'type' => 'App\Institution',
    ],
    [
        'id' => '11',
        'name' => 'Supplier',
        'type' => 'App\Supplier',
    ],
    [
        'id' => '12',
        'name' => 'User',
        'type' => 'App\User',
    ],
    [
        'id' => '13',
        'name' => 'PurchaseOrder',
        'type' => 'App\PurchaseOrder',
    ],

]);

$users = User::all();
//  dd($auditble_types[1]['id']);

return view('/panel.audit.audit_trail.index', compact('users', 'auditble_types'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //dd($request->all());
      $audit_type = $request->audit_type;
      $user_id = $request->user_id;
      $start_date = Carbon::parse($request->start_date)->format('Y/m/d');
      $end_date = Carbon::parse($request->end_date)->format('Y/m/d');
   // dd($start_date);
      $auditables = \OwenIt\Auditing\Models\Audit::
      select('audits.*')
      ->when($user_id, function ($query) use ($user_id) {
      return $query->where('user_id', '=', $user_id);
        })
       ->when($audit_type,function($query) use ($audit_type){
        return $query->where('auditable_type', '=', $audit_type);
        if (!$start_date && $end_date) {
        $auditable->where('created_at', '>', $end_date)->get();
        }else if($start_date && !$enddate){
          $auditable->where('created_at', '<', $start_date)->get();
  
        }
      

       })->get();
      
     // dd($auditables[0]->new_values['user_id']);

        return view('/panel.audit.audit_trail.create', compact('auditables'));

   
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
