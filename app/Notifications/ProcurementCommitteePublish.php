<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ProcurementCommittee;


class ProcurementCommitteePublish extends Notification implements ShouldQueue
{
    use Queueable;
    protected $committee;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProcurementCommittee $committee)
    {
        //
        $this->committee = $committee;
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
        ->subject('Procurement Committee')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('The Procurement Committee has endorsed the requisition,The number is '.$this->committee->requisition->requisition_no.'.')
        ->action('Approve', url('https://procurement.serha.gov.jm//entity_head_approve'))
        ->line('Thank you for using this application!');
        // ->attach('storage/documents/'.$this->filename);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
