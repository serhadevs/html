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


    // public function notification()
    // {
    //     return $this->hasMany('App\Notifications\InternalRequisitionPublish');
    // }
}
