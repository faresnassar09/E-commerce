<?php

namespace App\Http\Controllers\Support;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\NewComplain;
use App\Http\Requests\Seller\ReplyOnComplain;
use App\Models\Support\Ticket;
use App\Models\Support\TicketReply;
use App\Services\FileServices;
use Illuminate\Support\Facades\Log;

class Complaint extends Controller
{

    public function __construct(public FileServices $fileService) {}

    public function index()
    {

        $tickets = $this->getTickets();
        return view('sellers.complaints.index', compact('tickets'));
    }


    public function store(NewComplain $request)
    {


        $ticket = new Ticket();

        $ticket->subject = $request->subject;
        $ticket->message = $request->details;
        $ticket->seller_id = AuthSeller::id();
        $ticket->save();

        Log::channel('seller')->info('ticket has been submited', [
            'seller_id' => AuthSeller::id(),
            'ticket_id' => $ticket->id,
            'ticked_subject' => $ticket->subject
        ]);

        if ($request->hasFile('images')) {

            $this->storeImages('ticket_images', 'ticket_id', $ticket->id, $request->images, 'ticket_complains_image');
        }
        return back()->with('succeed', "your complaint has been recived we'll replay soon");
    }

    public function show($id)
    {

        $ticket = $this->findTicket($id);


        if (!$ticket) {

            Log::channel('seller')->info('ticket is not found', [
                'seller_id' => AuthSeller::id(),
                'ticket_id' => $id,
            ]);

            return back()->with('failed', 'the ticket is not found');
        }

        return view('sellers.complaints.show', compact('ticket'));
    }

    public function submitReply(ReplyOnComplain $request, $ticketId)
    {


        $reply = new TicketReply();

        $reply->ticket_id = $ticketId;
        $reply->message = $request->message;
        $reply->sender_type = 'seller';

        $reply->save();

        if ($request->hasFile('images')) {

            $this->storeImages('ticket_reply_images', 'ticket_reply_id', $reply->id, $request->images, 'ticket_complaints_reply_images');
        }

        return back()->with('succees', 'your reply has been succeesfully recived');
    }

    public function deleteTicket($id)
    {

        $ticket = $this->findTicket($id);

        $ticketAndReplyImages = null;

        if (!$ticket) {

            return back()->with('failed', 'the ticket is not found');

            Log::channel('seller')->warning('ticket not found', [
                'seller_id' => AuthSeller::id(),
                'ticket_id' => $id,
            ]);
        }

        $ticketAndReplyImages = $this->getTicketAndReplyImages($ticket); 

        if($ticketAndReplyImages){

         $this->fileService->deleteMultiImages($ticketAndReplyImages);
     
        }


        $ticket->delete();

        return back()->with('success', 'the ticket has been colsed successfully');
    }

    public function getTickets()
    {


        return AuthSeller::fullInfo()
            ->tickets()
            ->with('images:ticket_id,path')
            ->get();
    }


    public function findTicket($id)
    {

        return AuthSeller::fullInfo()?->tickets()->with('images', 'replies.images')->find($id);
    }
    public function storeImages($table, $foreignIdColumn, $foreignIdValue, $images, $folder)
    {

        $this->fileService->uploadMultipleImages(

            $table,
            $foreignIdColumn,
            $foreignIdValue,
            $images,
            $folder,
        );
    }

    public function getTicketAndReplyImages($ticket)
    {

        return  $ticket->replies->flatMap(function ($reply) {

            return $reply->images;
        })->merge($ticket->images);
    }
}
