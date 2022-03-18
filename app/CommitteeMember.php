<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitteeMember extends Model
{
    //
    protected $fillable = ['name','decision','signature','procurement_committee_id','date'];
    use SoftDeletes;
    public function action_taken()
    {
        return $this->HasOne('App\ActionTaken','id','decision');
    }

}

