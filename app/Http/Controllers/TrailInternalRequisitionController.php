<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\InternalRequisition;
use App\User;




class TrailInternalRequisitionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,3,6,12,15])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        //dd('test');
        return view('/panel.audit.trail_ipr.index');

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
       
$start_date = Carbon::parse($request->start_date);
$end_date = Carbon::parse($request->end_date);
// $event ='created';
// $internal = \OwenIt\Auditing\Models\Audit::select('audits.*')
// ->when($event, function ($query) use ($event) {
//         return $query->where('event', '=','created');
//         if (!$start_date && $end_date) {
//             $event->where('created_at', '>', $end_date)->get();
//         } else if ($start_date && !$enddate) {
//             $event->where('created_at', '<', $start_date)->get();

//         }

//     })->get();

// $internalrequisitions = InternalRequisition::with(['approve_internal_requisition', 'budget_commitment'])
//     ->whereHas('approve_internal_requisition', function ($query) {
//         $query->where('is_granted', '=', 1);
//     })

//     ->doesnthave('budget_commitment')
//     ->get();

    $internal_requisitions = InternalRequisition::with(['user'])
    ->whereBetween('internal_requisitions.created_at', [$start_date, $end_date->format('Y-m-d')." 23:59:59"])
    ->get();

    //$user = User::FindUser(1,1);
   // dd( $user);
   return view('/panel.audit.trail_ipr.show', compact('internal_requisitions'));

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
