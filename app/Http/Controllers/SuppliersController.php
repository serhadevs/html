<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Parish;
use Illuminate\Support\Facades\Cache;



class SuppliersController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,9,12,15])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        $suppliers = Supplier::all();

        return view('/panel.suppliers.index',['suppliers'=>$suppliers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parishes = Parish::all();
       
        
        return view('/panel.suppliers.create',compact('parishes'));

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

      
        $request->validate([
            'name' => 'required',
            'supplier_code' => 'required',
            'trn' => 'required|unique:suppliers,trn',
            'phone'=> 'required',
            'address'=> 'required',
            'city'=> 'required',
            'parish_id'=> 'required',
            'country'=> 'required',
            'email' => 'required|email|unique:suppliers,email'
            
                ]);
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->supplier_code = $request->supplier_code;
        $supplier->trn =$request->trn;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->email = $request->email;
        $supplier->parish_id= $request->parish_id;
        $supplier->country = $request->country;

        $supplier->save();
        return redirect('/suppliers')->with('status', 'Suppliers was created successfully');

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
    public function edit(Supplier $supplier)
    {
        //
       // dd('test');
       $parishes = Parish::all();

        return view('/panel.suppliers.edit',compact('supplier','parishes'));

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
            'supplier_code' => 'required',
            'trn' => 'required|digits:9',
            'phone'=> 'required',
            'address'=> 'required',
            'city'=> 'required',
            'parish_id'=> 'required',
            'country'=> 'required',
            'email' => 'required|email'
            
                ]);
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->supplier_code = $request->supplier_code;
        $supplier->trn =$request->trn;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;
        $supplier->email = $request->email;
        $supplier->parish_id= $request->parish_id;
        $supplier->country = $request->country;

        $supplier->update();
        return redirect('/suppliers')->with('status', 'Suppliers was updated successfully');

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
            $supplier = Supplier::find($id);
            $supplier->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }
    }
}
