<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\InternalRequisition;


class CertifiedInternalRequisitionPublish extends Notification implements ShouldQueue
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
        return ['mail','database'];
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
        ->subject('Certified internal requisition ')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('The internal requisition is ready to be certified,the requisition number is '.$this->internal->requisition_no.'.')
        ->line($this->internal->description)
        ->action('Certify Now', url('https://procurement.serha.gov.jm/certify-internal-requisition/'. $this->internal->id))
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
