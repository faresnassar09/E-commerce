<?php

namespace App\Policies\Seller;

use App\Models\Admin\Admin;
use App\Models\Seller\Seller;
use App\Models\Support\Ticket;

class ComplaintPolicy
{

    public function view(Admin|Seller $seller,Ticket $ticket ): bool
    {      
        
        if ($seller instanceof Admin) {
        return true;
    }
        return $seller->id === $ticket->seller_id;
    }


    public function createReply(Admin|Seller $seller,Ticket $ticket ): bool
    {

        if ($seller instanceof Admin) {
            return true;
        }

        return $seller->id === $ticket->seller_id;
    }

    public function delete(Admin|Seller $seller,Ticket $ticket): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }
        return $seller->id === $ticket->seller_id;
    }
    
}
