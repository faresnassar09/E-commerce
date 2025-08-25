<?php 

namespace App\Services\Seller;

use App\Facades\AuthSeller;

class ComplaintService {


    public function createTicket($data){

       return AuthSeller::fullInfo()
        ->tickets()
        ->create([

            'subject' => $data->subject,
            'message' => $data->details,
        ]);

    }

        public function getTickets()
        {
    
    
            return AuthSeller::fullInfo()
                ->tickets()
                ->with('images:ticket_id,path')
                ->get();
        }

        public function createReply($ticket,$data){

            return $ticket->replies()->create([

                'message' => $data->message,
                'sender_type' => 'seller'
            ]);
            
        }
        
    

    public function insertImages($model, $imagesPaths)
    {


        foreach ($imagesPaths as $imagePath) {

            $model->images()->create([

                'path' => $imagePath,
            ]);
        }
    }

    public function collectTicketAndTicketRepliesImages($ticketImages,$ticketReplyImages) {


        return $ticketImages->merge($ticketReplyImages->pluck('images')->flatten());
        
    }

    public function deleteTicket($ticket) {

        $ticket->delete();

        
    }

}