<?php

namespace App\Listeners;

use App\Events\NotificationPublished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ContactSupplier;
use Illuminate\Support\Facades\Mail;


class NotificationPublishListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationPublished  $event
     * @return void
     */
    public function handle(NotificationPublished $event)
    {
        //
       //dd($event->purchaseorder->id);
        //$event->$user->notify(new NewUserAccountPublish());
        // Mail::to($event->purchaseorder->requisition->supplier->email)
        // ->send(new ContactSupplier($event->purchaseorder));
    }
}
