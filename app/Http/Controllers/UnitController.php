<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Department;

class UnitController extends Controller
{
    //
     public function __construct(Request $request)
    {

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,3,9,12,15])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }

    public function index()
    {
        //dd('test');
        $units = Unit::all();

        return view('/panel.unit.index',compact('units'));
    }


    public function create()
    {
        //
        $departments = Department::all();
      
        return view('/panel.unit.create',compact('departments'));

    }
    public function store(Request $request)
    {
     
        $request->validate([
    'name' => 'required',
    'department_id' => 'required',
   

    ]);

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->department_id = $request->department_id;
        $unit->save();

        return redirect('/unit')->with('status', 'Unit was created successfully');

    }

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
        $unit = Unit::find($id);
        $departments = Department::all();

        return view('/panel.unit.edit',compact('unit','departments'));
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
           
        
            ]);
            $unit = Unit::find($id);
            $unit->name = $request->name;
            $unit->department_id = $request->department_id;
            $unit->update();
            return redirect('/unit')->with('status', 'Department Unit was updated successfully');
    }


    public function destroy($id)
    {
        try {
    $unit = Unit::find($id);
    $unit->delete();
    return "success";
} catch (Exception $e) {
    return 'fail';
}

    }
}
