<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Requisition;
use App\Comment;

class RefuseRequisitionPublish extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requisition $requisition, Comment $comment)
    {
        //
        $this->requisition = $requisition;
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
        ->subject('Refuse Requisition')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('Your requisition was refused,the requisition number is '.$this->requisition->requisition_no.'.')
        ->line($this->requisition->description)
        ->line($this->comment->comment)
        ->action('View Requisition', url('/check-purchase'. $this->requisition->id.'/edit'))
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
