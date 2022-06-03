<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use DB;



class User extends Authenticatable implements Auditable
{
    use Notifiable;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'role_id', 'department_id', 'institution_id', 'telephone','unit_id','password_changed_at','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo('App\Role');

    }
    public function institution()
    {
        return $this->belongsTo('App\Institution')->withTrashed();
    }
    public function department()
    {
        return $this->belongsTo('App\Department')->withTrashed();
    }
     public function unit()
    {
        return $this->belongsTo('App\Unit')->withTrashed();
    }

    public function abbrName()
    {
        return $this->firstname[0] . '. ' . $this->lastname;
    }

    public function fullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function approve()
    {
        return $this->hasMany('App\Approve');
    }

    public function accept()
    {
        return $this->hasMany('App\Check');

    }

    public function requisition()
    {
        return $this->hasMany('App\Requisition');
    }

    public function purchaseOrder()
    {
        return $this->hasMany('App\Requisition');
    }

      public function assignTO()
    {
        return $this->hasMany('App\AssignRequisition');
    }

    public static function findUser($role_id,$department_id,$institution_id)
    {
        if($department_id==null){
        $user=User::where('role_id',$role_id)->where('institution_id',$institution_id)->first();
        }else{
        $user = User::where('role_id', $role_id)->where('department_id', $department_id)
        ->where('institution_id', $institution_id)
        ->first();    
        }

        if($user ==null){
            return 'no user ';
        }
        return $user->firstname[0].'.'.$user->lastname;
    }

    public function institution_users()
    {
        return $this->hasMany('App\InstitutionUsers');
    }
    public function department_users()
    {
        return $this->hasMany('App\DepartmentUsers');
    }
    public function unit_users()
    {
        return $this->hasMany('App\UnitUsers');
    }
    public function user_roles()
    {
        return $this->hasMany('App\UserRoles');
    }
   
    //institutions ids for a user
    public static function accessInstitutions(){
        $institution_ids = InstitutionUsers::where('user_id',auth()->user()->id)->pluck('institution_id');
        $institutions = Institution::whereIn('id',$institution_ids)->get();
  
        return $institutions;
      }

      public static function accessDepartments(){
        $department_ids = DepartmentUsers::where('user_id',auth()->user()->id)->pluck('department_id');
        $departments = Department::whereIn('id',$department_ids)->get();
  
        return $departments;
      }
      public static function accessUnits(){
        $unit_ids = UnitUsers::where('user_id',auth()->user()->id)->pluck('unit_id');
        $units = Unit::whereIn('id',$unit_ids)->get();
  
        return $units;
      }

      public static function accessInstitutions_Id(){
        $institutions_id = InstitutionUsers::where('user_id',auth()->user()->id)->pluck('institution_id');
       // $institutions = Institution::whereIn('id',$institution_ids)->pluck('id');
  
        return $institutions_id;
      }

      public static function accessDepartments_Id(){
        $departments_id = DepartmentUsers::where('user_id',auth()->user()->id)->pluck('department_id');
       // $institutions = Institution::whereIn('id',$institution_ids)->pluck('id');
  
        return $departments_id;
      }

      public static function accessUnits_Id(){
        $units_id = UnitUsers::where('user_id',auth()->user()->id)->pluck('unit_id');
       // $institutions = Institution::whereIn('id',$institution_ids)->pluck('id');
  
        return $units_id;
      }

      public static function userRoles_Id(){
        $roles_id = UserRoles::where('user_id',auth()->user()->id)->pluck('role_id');
        return $roles_id;
      }
    
      //all subcribe users for a institution
      public static function users_in_institution($institutions_id)
      {
        $user_ids = \App\InstitutionUsers::where('institution_id',$institutions_id)->pluck('user_id');
        $users = User::whereIn('id', $user_ids)
       ->get();
        return $users;

      }

      public static function users_in_institution_ids($institutions_id)
      {
        $users_ids = \App\InstitutionUsers::where('institution_id',$institutions_id)->pluck('user_id'); 
     
        return $users_ids;

      }

      // all subscribe users for a department

      public static function users_in_departments($department_id)
      {
        $user_ids = \App\DepartmentUsers::where('department_id',$department_id)->pluck('user_id');
        $users = User::whereIn('id', $user_ids)
       ->get();
        return $users;

      }

      public static function users_in_departments_ids($department_id)
      {
        $users_ids = \App\DepartmentUsers::where('department_id',$department_id)->pluck('user_id'); 
     
        return $users_ids;

      }









      //

      public static function unitUsers(){
        $unit_users = User::where('unit_id', auth()->user()->unit_id)
                        ->withTrashed()
                        ->get();

        return $unit_users;
    }

    public static function department_count($department_id)
      {
       // $user_ids = \App\InstitutionUsers::where('institution_id',$institutions_id)->pluck('user_id');
        $count = User::where('department_id',$department_id)
       ->count();
        return $count;

      }
      public static function institution_count($institution_id)
      {
       // $user_ids = \App\InstitutionUsers::where('institution_id',$institutions_id)->pluck('user_id');
        $count = User::where('institution_id',$institution_id)
       ->count();
        return $count;

      }
    //user with multiple user roles
    public static function user_with_roles($institution_id,$department_id,$role_id){
    $users = User::with('user_roles')
    ->where(function($query){
        $query->where('department_id',auth()->user()->department_id)
        ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
    })
    ->where(function($query){
        $query->where('institution_id','=',auth()->user()->institution_id)
        ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id()->where('department_id',auth()->user()->department_id));

     })
    ->whereHas('user_roles',function($query)use($role_id){
        $query->where('role_id',$role_id);
    })
     ->Orwhere(function($query)use($role_id,$institution_id){
       $query->where('role_id',$role_id)->where('institution_id',$institution_id);
     })
    ->get();
    return $users;
    }
  


 

    
}
