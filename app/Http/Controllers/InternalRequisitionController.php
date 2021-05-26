<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternalRequisition;
use App\Stock;
use App\UnitOfMeasurement;
use App\ProcurementMethod;
use App\RequisitionType;
use App\User;
use App\Comment;
use App\Unit;
use App\Notifications\InternalRequisitionPublish;
use App\SystemOperations\RequisitionNumberGenerator;
use App\ApproveInternalRequisition;
use App\CertifiedInternalRequisition;



class InternalRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $internal_requisitions =  InternalRequisition::where('department_id',auth()->user()->department_id)
      ->where('institution_id',auth()->user()->institution_id)->get();

        return view('/panel.irf.index',compact('internal_requisitions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $units = UnitOfMeasurement::all();
        $methods = ProcurementMethod::all();
        $types = RequisitionType::all();
       

        return view('/panel.irf.create',compact('units','types','methods'));

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
    'estimated_cost' => 'required',
    'budget_approve' => 'required',
    'phone' => 'required',
    'email' => 'required',
    'requisition_type' => 'required',
    'priority' => 'required',
    
                        'quantity' => 'required',
                        'description' => 'required',
                        'part_number' => 'required',
                        'unit'=>'required',
                        'unit_cost' =>'required',
                      
    
]);
    $requisition_no = new RequisitionNumberGenerator();
    $internal_requisition = new InternalRequisition();
    
    $internal_requisition->requisition_no = $requisition_no->generateRequisitionNumber($request->requisition_type);
    $internal_requisition->user_id = auth()->user()->id;
    $internal_requisition->institution_id = auth()->user()->institution_id;
    $internal_requisition->department_id = auth()->user()->department_id;
    $internal_requisition->estimated_cost = $request->estimated_cost;
    $internal_requisition->budget_approve = $request->budget_approve;
    $internal_requisition->phone = $request->phone;
    $internal_requisition->email = $request->email;
    $internal_requisition->requisition_type_id = $request->requisition_type;
    $internal_requisition->budget_approve = $request->budget_approve;
    $internal_requisition->comments = $request->comments;
    $internal_requisition->priority = $request->priority;

      
    if ($internal_requisition->save()) {

            $input = $request->all();
            // $product = $request->input('product_name',[]);
          //  dd($input['part_number'][0]);
             if ($input['item_number'][0]) {
                foreach ($input['item_number'] as $key => $stocks) {
                        $stock = Stock::create([
                        'item_number' => $input['item_number'][$key],
                        'quantity' => $input['quantity'][$key],
                        'description' => $input['description'][$key],
                        'part_number' => $input['part_number'][$key],
                        'unit_of_measurement_id' => $input['unit'][$key],
                        'unit_cost' => $input['unit_cost'][$key],
                        'internal_requisition_id' => $internal_requisition->id,
                    ]);
                   
                }
          
            } 

        }

       

       $unit_count = Unit::where('department_id',auth()->user()->department_id)->count();

       if($unit_count==1){

        $certify = new CertifiedInternalRequisition();
        $certify->internal_requisition_id = $internal_requisition->id;
        $certify->user_id = auth()->user()->id;
        $certify->is_granted = 1;
        $certify->save();


        $users = User::where('institution_id',auth()->user()->institution_id )
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id',[1,2])
        ->get();
        $users->each->notify(new InternalRequisitionPublish($internal_requisition));

       }else{

        $users = User::where('institution_id',auth()->user()->institution_id )
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id',[13])
        ->get();
        $users->each->notify(new InternalRequisitionPublish($internal_requisition));


       }
    


       

        return redirect('/internal_requisition')->with('status', 'Internal Requisition was created successfully');

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
        $internal_requisition = InternalRequisition::find($id);
        return view('/panel.irf.show', compact('internal_requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
  
        $units = UnitOfMeasurement::all();
       //  dd(('test'));
        $ir = InternalRequisition::with(['stocks','comment'])
        ->find($id);
      // dd($ir->comment);
      $types = RequisitionType::all();

      if ($ir->approve_internal_requisition) {
        if($ir->approve_internal_requisition->is_granted===1)
        return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already approved.');
    }else{
        if($ir->certified_internal_requisition->is_granted===1)
        return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already certified.');
    }

        return view('/panel.irf.edit', compact('units','ir','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      //dd($request->all());
          $internal_requisition = InternalRequisition::with(['stocks'])->find($id);
         
            // $internal_requisition->user_id = auth()->user()->id;
            // $internal_requisition->institution_id = auth()->user()->institution_id;
            // $internal_requisition->department_id = auth()->user()->department_id;
            $internal_requisition->estimated_cost = $request->estimated_cost;
            $internal_requisition->budget_approve = $request->budget_approve;
            $internal_requisition->phone = $request->phone;
            $internal_requisition->email = $request->email;
            $internal_requisition->requisition_type_id = $request->requisition_type;
            $internal_requisition->budget_approve = $request->budget_approve;
            $internal_requisition->priority = $request->priority;
            $internal_requisition->comments = $request->comments;
           // dd( $internal_requisition);
             if ($internal_requisition->update()) {

                $approve = ApproveInternalRequisition::where('internal_requisition_id',$id)
            ->where('is_granted',0)
            ->first();
            if($approve != null){
            $approve->delete();
            }else{
                $approve = null;
            }
            $certify = CertifiedInternalRequisition::where('internal_requisition_id',$id)
            ->where('is_granted',0)
            ->first();
            if($certify != null){
            $certify->delete();
            }else{
            $certify = null;
            }

            $input = $request->all();

            // $products = Stock::find($requisition->id);
            // dd($products);
            foreach ($internal_requisition->stocks as $products) {
                $products->delete();
            }

          if ($input['item_number'][0]) {
            foreach ($input['item_number'] as $key => $stocks) {
                $stock = Stock::create([
            'item_number' => $input['item_number'][$key],
            'quantity' => $input['quantity'][$key],
            'description' => $input['description'][$key],
            'part_number' => $input['part_number'][$key],
            'unit_of_measurement_id' => $input['unit'][$key],
            'unit_cost' => $input['unit_cost'][$key],
            'internal_requisition_id' => $internal_requisition->id,
        ]);

    }

}

        }

        return redirect('/internal_requisition')->with('status', 'Internal requisition was updated successfully');

     
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
            $internal_requisition = InternalRequisition::find($id);
            $internal_requisition->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }
        
    }
}
