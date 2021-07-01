<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitOfMeasurement;


class UnitMeasurementController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,9,12])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        $measurements = UnitOfMeasurement::all();
        return view('/panel.measurement.index',compact('measurements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
   
        return view('/panel.measurement.create');
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
            'name' => 'required',
            'abbr' => 'required',
            'description' => 'required'
        
                ]);
                $measurement = new UnitOfMeasurement();
                $measurement->name = $request->name;
                $measurement->abbr = $request->abbr;
                $measurement->description = $request->description;
                $measurement->save();

                return redirect('/measurement')->with('status', 'Unit of Measurement was created successfully');
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
    public function edit(UnitOfMeasurement $measurement)
    {
        

        return view('/panel.measurement.edit',compact('measurement'));
       
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
        $request->validate([
            'name' => 'required',
            'abbr' => 'required',
            'description' => 'required'
        
                ]);
                $measurement = UnitOfMeasurement::find($id);
                $measurement->name = $request->name;
                $measurement->abbr = $request->abbr;
                $measurement->description = $request->description;
                $measurement->update();

    return redirect('/measurement')->with('status', 'Unit of Measurement was updated successfully');
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
        try {
            $measurement = UnitOfMeasurement::find($id);
            $measurement->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }
    }
}
