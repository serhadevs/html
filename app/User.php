<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;



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
        'firstname', 'lastname', 'email', 'password', 'role_id', 'department_id', 'institution_id', 'telephone','unit_id','password_changed_at'
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
   
    //institutions ids for a user
    public static function accessInstitutions(){
        $institution_ids = InstitutionUsers::where('user_id',auth()->user()->id)->pluck('institution_id');
        $institutions = Institution::whereIn('id',$institution_ids)->get();
  
        return $institutions;
      }

      public static function accessInstitutions_Id(){
        $institutions_id = InstitutionUsers::where('user_id',auth()->user()->id)->pluck('institution_id');
       // $institutions = Institution::whereIn('id',$institution_ids)->pluck('id');
  
        return $institutions_id;
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

      public static function unitUsers(){
        $unit_users = User::where('unit_id', auth()->user()->unit_id)
                        ->withTrashed()
                        ->get();

        return $unit_users;
    }


 

    
}
