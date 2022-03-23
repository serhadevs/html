<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProcurementCommittee extends Model implements Auditable
{
    //
    protected $guarded = ['*'];
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function requisition()
    {
      return  $this->belongsTo('App\Requisition');
    }

    public function members()
    {
        return $this->hasMany('App\CommitteeMember');
    }

    public function meeting_type()
    {
       // return $this->hasOne('App\MeetingType');
        return $this->HasOne('App\MeetingType','id','meeting_type_id');
    }

    public function action_taken()
    {
        return $this->HasOne('App\ActionTaken','id','action_taken_id');
    }

}
