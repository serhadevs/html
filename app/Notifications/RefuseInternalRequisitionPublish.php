<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\InternalRequisition;
use App\Comment;

class RefuseInternalRequisitionPublish extends Notification
{
    use Queueable;
    protected $internal;
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InternalRequisition $internal,Comment $comment)
    {
        //
        $this->internal = $internal;
        $this->comment =$comment;
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
        ->subject('Refuse internal requisition ')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('The internal requisition was refuse,the requisition number is '.$this->internal->requisition_no.'.')
        ->line('The item description is '.$this->internal->description.'.')
        ->line($this->comment->comment)
       // ->action('View Requisition', url('internal_requisition/'. $this->internal->id.'/edit'))
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
