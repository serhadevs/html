<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Requisition;

class RequisitionPublish extends Notification implements ShouldQueue
{
    use Queueable;
    protected $requisition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requisition $requisition)
    {
        //
        $this->requisition = $requisition;

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
        ->subject('Requisition')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('A new requisition was recieved, requisition number is '.$this->requisition->requisition_no.'.')
        ->line($this->requisition->description)
        ->action('View requisition', url('check-purchase/'. $this->requisition->id))
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
        return $this->requisition->toArray();
    }
}
