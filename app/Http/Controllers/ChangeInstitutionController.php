<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\InstitutionUsers;


class ChangeInstitutionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,3,6,10,11,12,14]) and ( !in_array(auth()->user()->id,[4])) ) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        // $requisition= \App\Requisition::find(8);
        // $access_users = \App\User::whereHas('institution_users',function($query){
        //     $query->where('institution_id',6);
        //     })->get();
        // dd ($access_users);
        if(in_array(auth()->user()->role_id,[1,12,15]))
    {
        $institutions = Institution::all();
    }else{

        // $institution_ids = InstitutionUsers::where('user_id',auth()->user()->id)->pluck('institution_id');
        // $institutions = Institution::whereIn('id',$institution_ids)->get();
       $institutions = auth()->user()->AccessInstitutions();
        
       
    }
        return view('/auth.change-institution',compact('institutions'));

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
            $institutions = \App\Institution::all();
            $user = \App\User::find($id);
            $user->institution_id = $request->institution;
            $user->update();
            return redirect('/change-institution')->with('status', 'Institution was successfully change.');

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
