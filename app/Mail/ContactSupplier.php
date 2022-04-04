<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PurchaseOrder;

class ContactSupplier extends Mailable 
{
    use Queueable, SerializesModels;

    public $purchaseOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PurchaseOrder $purchaseOrder )
    {
        //
     $this->purchaseOrder = $purchaseOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('/panel.mail.contact-supplier')
        ->subject('Purchase Order');
        //->attach(asset('storage/documents/'.$this->purchaseOrder->attached[0]->filename));
        foreach($this->purchaseOrder->attached as $file){
         $email->attach(asset('storage/documents/'.$file->filename));
        }
        return $email;
      
    }
}
