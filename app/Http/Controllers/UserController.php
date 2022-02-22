<?php

namespace App\Http\Controllers;

use App\Department;
use App\Institution;
use App\Parish;
use App\Role;
use App\User;
use App\Unit;
use App\InstitutionUsers;
use App\DepartmentUsers;
use App\UnitUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rules\OldPasswordChecker;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewUserAccountPublish;
use App\Notifications\PasswordResetPublish;
use Illuminate\Support\Str;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(Request $request)
    {

        // dd($request->path());
         if ($request->path() == "/change-password/user") {
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2,3,9,12])) {
                return redirect('/dashboard')->with('error','Access Denied');
            } else {
                return $next($request);
            }
        });
         }
    }
    public function index()
    {
        //
        
       
        if(in_array(auth()->user()->role_id,[1,12]) OR Auth::user()->role_id===2 And Auth::user()->department_id===1){
        $users = User::with(['institution','department','role','unit'])->get();
        }else{
        $users = User::with(['institution','department','role','unit'])->where('institution_id','=',auth()->user()->institution_id)
        ->whereNotIn('role_id',[1,12])
        ->get();
        }

        //dd($users);
        return view('/panel.user.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parishes = Parish::all();
        $departments = Department::all();
        $institutions = Institution::all();
        $roles = Role::all();
        $units = Unit::all();
        
        
        return view('/panel.user.create', compact('units','institutions', 'roles', 'departments', 'parishes'));

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
        try{
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            // 'telephone' => 'required|min:11|numeric',
            'institution' => 'required',
            'department' => 'required',
            'unit_id' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = new User();
        $user->firstname = $request->first_name;
        $user->lastname = $request->last_name;
        $user->role_id = $request->role;
        $user->telephone = $request->telephone;
        $user->institution_id = $request->institution;
        $user->department_id = $request->department;
        $user->email = $request->email;
        $user->unit_id = $request->unit_id;
        $user->password = bcrypt(('password123'));
        $user->save();

        $institutions = $request->institutions;
        $departments = $request->departments;
        $units = $request->units;
        if (!empty($institutions)) {
            foreach ( $institutions as $key => $institution) {
                $institution =InstitutionUsers::create([
                    'user_id' => $user->id,
                    'institution_id' => $institution,
                    'primary' => $user->institution_id,
                
                ]);

            }

        }
        if (!empty($departments)) {
            foreach ( $departments as $key => $department) {
                $department =DepartmentUsers::create([
                    'user_id' => $user->id,
                    'department_id' => $department,
                    'primary' => $user->department_id,
                
                ]);

            }

        }
        if (!empty($units)) {
            foreach ( $units as $key => $unit) {
                $unit =UnitUsers::create([
                    'user_id' => $user->id,
                    'unit_id' => $unit,
                    'primary' => $user->unit_id,
                
                ]);

            }

        }




        $user->notify(new NewUserAccountPublish());

        }catch(QueryException $ex ){
          //  dd($ex->getMessage());
        abort(500,'something went wrong');
        }

        return redirect('/user')->with('status', 'User was created successfully');
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
    public function edit(User $user)
    {

        $parishes = Parish::all();
        $departments = Department::all();
        $institutions = Institution::all();
        $roles = Role::all();
        $units = Unit::all();
       

        return view('panel.user.edit', compact('units','institutions', 'roles', 'departments', 'parishes', 'user'));

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
       // dd($request->all());
        $institutions = $request->institutions;
        $departments = $request->departments;
        $units = $request->units;
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            // 'institution' => 'required',
            'department' => 'required',
            'unit_id' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::find($id);
        $user->firstname = $request->first_name;
        $user->lastname = $request->last_name;
        $user->role_id = $request->role;
        $user->telephone = $request->telephone;
        $user->institution_id = $request->institution;
        $user->department_id = $request->department;
        $user->email = $request->email;
        $user->unit_id = $request->unit_id;
        $user->update();
        
        //remove institution_users list
        
        foreach($user->institution_users as $institution){
            $institution->delete();
        }
        foreach($user->department_users as $department){
            $department->delete();
        }
        foreach($user->unit_users as $unit){
            $unit->delete();
        }
        
        //make or update new list
        if (!empty($institutions)) {
            foreach ( $institutions as $key => $institution) {
                $institution =InstitutionUsers::create([
                    'user_id' => $user->id,
                    'institution_id' => $institution,
                    'primary' => $user->institution_id,
                
                ]);

            }
        }
        if (!empty($departments)) {
            foreach ( $departments as $key => $department) {
                $department =DepartmentUsers::create([
                    'user_id' => $user->id,
                    'department_id' => $department,
                    'primary' => $user->department_id,
                
                ]);

            }

        }
        if (!empty($units)) {
            foreach ( $units as $key => $unit) {
                $unit =UnitUsers::create([
                    'user_id' => $user->id,
                    'unit_id' => $unit,
                    'primary' => $user->unit_id,
                
                ]);

            }

        }

        

        return redirect('/user')->with('status', 'User profile was updated successfully');

    }

    public function reset($id)
    {
        $password = Str::random(8);
        $user = \App\User::find($id);
        $user->password = bcrypt($password);
        $user->update();

        $user->notify(new PasswordResetPublish($password));
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Request $request)
    {
        //dd('change password');
        $request->validate([
            'current_password' => ['required', new OldPasswordChecker],
            'new_password' => 'required|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth::user();
        $user->password = bcrypt($request->new_password);
        $user->password = bcrypt($request->new_password);
        $user->password_changed_at = Carbon::now()->toDateTimeString();

        $user->update();

        return redirect('/change-password')->with('status', 'Password was successfully changed.');
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }


   
    }

    public function verify_password(Request $request)
    {


        // $credentials = $request->validate([
        //     'email'=>'email',
        //     'password'=>'required',
   
        //     ]);      

        
            $user = User::where('email',$request->email)->first();
            $password = bcrypt($request->password);
            // return "success";

            if($user->email = $request->email)
            {
                return 'success';

            }else
            {
                return "fail";
            }
            
            
   
             return "fail";
       
      
    }
   
}
