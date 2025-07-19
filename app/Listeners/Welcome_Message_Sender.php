<?php

namespace App\Listeners;

use App\Events\Mails\Send_Welcome_Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Send_Mail;

class Welcome_Message_Sender
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Send_Welcome_Message $event): void
    {

          Send_Mail::Wellcome_Message($event->email);

    }
}
