<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Notifications\ApproveRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\Notifications\AcceptRequisitionPublish;
use App\User;
use App\Comment;
use App\Check;
use App\Status;
use App\StoreApproves;


class EntityHeadApprove extends Model implements Auditable
{
    //
  
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['requisition_id','is_granted','user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
