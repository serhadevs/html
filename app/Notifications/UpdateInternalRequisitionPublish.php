<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\InternalRequisition;

class UpdateInternalRequisitionPublish extends Notification implements ShouldQueue
{
    use Queueable;
    protected $internal;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InternalRequisition $internal)
    {
        //
        $this->internal = $internal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Updated Internal Requisition ')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('The Internal requisition was updated  and is ready to get approved,the requisition number is '.$this->internal->requisition_no.'.')
        ->line($this->internal->description)
        ->action('Approve it Now', url('https://procurement.serha.gov.jm/approve-internal-requisition/' . $this->internal->id))
        ->line('Thank you for using this application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->internal->toArray();
    }
}
