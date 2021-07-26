<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\PurchaseOrder;

class PurchaseOrderPublish extends Notification
{
    use Queueable;
    //protected $filename;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PurchaseOrder $purchase_order)
    {
        $this->purchase_order = $purchase_order;
  
      
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
        ->subject('Purchase Order')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('Your purchase order was created,the requisition number is '.$this->purchase_order->requisition->requisition_no.'.')
        // ->action('Add payment voucher', url('/payment-voucher'))
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
        return $this->purchase_order->toArray();
    }
}
