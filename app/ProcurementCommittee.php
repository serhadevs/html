<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcurementCommittee extends Model
{
    //
    protected $guarded = ['*'];
    use SoftDeletes;

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
