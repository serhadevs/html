<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\PurchaseOrder;



class NotificationPublished
{
    use Dispatchable,SerializesModels;
   // public  $purchaseorder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($purchaseorder)
    {
        //
        $this->purchaseorder = $purchaseorder;
        //dd( $this->purchaseorder);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
