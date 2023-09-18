<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\PaymentVoucher;


class RefuseVoucherCheck extends Notification  
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PaymentVoucher $payment_voucher)
    {
        //
        $this->payment_voucher = $payment_voucher;
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
        ->subject('Payment Voucher Check')
        ->greeting('Good day , ' .$notifiable->firstname )
        ->line('The Payment Voucher was refuse,the voucher number is '.$this->payment_voucher->voucher_no.'.')
        //->action('Certyfing Voucher', url('/certifying-voucher'. $this->payment_voucher->id))
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
        return $this->payment_voucher->toArray();
    }
}
