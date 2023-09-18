<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parish;
use App\Institution;

class InstitutionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,3,9,12,15])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {

        $institutions = Institution::all();


        return view('/panel.institution.index',compact('institutions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parishes = Parish::all();

        return view('/panel.institution.create',compact('parishes'));

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

        $request->validate([
    'name' => 'required',
    'institution_code' => 'required|max:10',
    'parish_id' => 'required',
    'code'=> 'required',
    
        ]);

        $institution = new Institution();
        $institution->name = $request->name;
        $institution ->abbr = $request->institution_code;
        $institution->code = $request->code;
        $institution ->parish_id = $request->parish_id;
        
        $institution ->save();


        return redirect('/institution')->with('status', 'Institution was created successfully');


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
    public function edit(Institution $institution)
    {
        $parishes = Parish::all();
        return view('/panel.institution.edit',compact('institution','parishes'));
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

          
        $request->validate([
            'name' => 'required',
            'institution_code' => 'required|max:3',
            'parish_id' => 'required',
            'code'=> 'required',
            
                ]);
        
                $institution = Institution::find($id);
                $institution->name = $request->name;
                $institution ->abbr = $request->institution_code;
                $institution->code = $request->code;
                $institution ->parish_id = $request->parish_id;
                
                $institution ->update();

                return redirect('/institution')->with('status', 'Institution was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
    $institution = Institution::find($id);
    $institution->delete();
    return "success";
} catch (Exception $e) {
    return 'fail';
}

    }
}
