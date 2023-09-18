<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserAccountPublish extends Notification implements ShouldQueue
{
    use Queueable;
    //protected $password;
    
    


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
       // $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Login')
                    ->greeting('Good day , ' .$notifiable->firstname )
                    ->line('A new account for you was created for SERHA Electronic Procurement System.')
                    ->line('Your login is your current email address and password.')
                    ->line('Your default password is password123.')
                    ->action('Sign In', url('/'))
                    ->line('Welcome to this application!');
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
