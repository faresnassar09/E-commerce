<?php

namespace App\Mail\User;

use App\Models\User\User;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

 public $page ;
 public $sellerPhoneNumber = [];
 public $userInfo = [];
 public $orderDetails = [];

    

    public function __construct($userInfo,$orderDetails,$sellerPhoneNumber,$page)
    {

        $this->page = $page;

        $this->sellerPhoneNumber = $sellerPhoneNumber;

        $this->userInfo = $userInfo;

        $this->orderDetails = $orderDetails;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(

            view: "users.mails.$this->page",

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
