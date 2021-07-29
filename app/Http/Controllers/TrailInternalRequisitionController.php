<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;


class TrailInternalRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
       
$start_date = Carbon::parse($request->start_date)->format('Y/m/d');
$end_date = Carbon::parse($request->end_date)->format('Y/m/d');
$event ='created';
$internal = \OwenIt\Auditing\Models\Audit::select('audits.*')
->when($event, function ($query) use ($event) {
        return $query->where('event', '=','created');
        if (!$start_date && $end_date) {
            $event->where('created_at', '>', $end_date)->get();
        } else if ($start_date && !$enddate) {
            $event->where('created_at', '<', $start_date)->get();

        }

    })->get();

   return view('/panel.audit.audit_trail.show', compact('internal'));

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
