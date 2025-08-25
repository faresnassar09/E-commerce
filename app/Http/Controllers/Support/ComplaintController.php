<?php

namespace App\Http\Controllers\Support;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ComplaintRequest;
use App\Http\Requests\Seller\ComplaintReplyRequest;
use App\Models\Support\Ticket;
use App\Services\FileServices;
use App\Services\Seller\ComplaintService;
use App\Services\Seller\LoggingService;
use Illuminate\Support\Facades\Gate;

class ComplaintController extends Controller
{

    public function __construct(

        public FileServices $fileService,
        public LoggingService $loggingService,
        public ComplaintService $complaintService,

    ) {}

    public function index()
    {

        $tickets = $this->complaintService->getTickets();

        return view('sellers.complaints.index', compact('tickets'));
    }


    public function store(ComplaintRequest $request)
    {

        try {

            $ticket = $this->complaintService->createTicket($request);

            $this->loggingService->success('Ticket has been submited', [
                'ticket_id' => $ticket->id,
                'tickt_subject' => $ticket->subject
            ]);

            if ($request->hasFile('images')) {

                $imagesPaths = $this->fileService->uploadMultipleImages(

                    $request->images,
                    'ticket_complains_images'
                );

                $this->complaintService->insertImages($ticket, $imagesPaths);
            }

            return back()->with('success', "your complaint has been recived we'll replay soon");
        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while saving ticket', [

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', "Unexpected error occurred while saving ticket");
        }
    }

    public function show(Ticket $ticket)
    {


        Gate::forUser(AuthSeller::fullInfo())->authorize('view', $ticket);



        return view('sellers.complaints.show', compact('ticket'));
    }

    public function submitReply(ComplaintReplyRequest $request, Ticket $ticket)
    {

        try {

            Gate::forUser(AuthSeller::fullInfo())->authorize('createReply', $ticket);

            $reply = $this->complaintService->createReply($ticket, $request);

            if ($request->hasFile('images')) {

                $imagesPaths = $this->fileService->uploadMultipleImages(

                    $request->images,
                    'ticket_complaints_replies_images'
                );

                $this->complaintService->insertImages($reply, $imagesPaths);
            }

            $this->loggingService->success('Ticket reply has been submited', [

                'reply_id' => $reply->id,
                'reply_subject' => $reply->subject
            ]);

            return back()->with('success', 'your reply has been succeesfully recived');

        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while saving ticket reply', [

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', "Unexpected error occurred while saving ticket reply");
        }
    }

    public function deleteTicket(Ticket $ticket)
    {
try {
    
        Gate::forUser(AuthSeller::fullInfo())->authorize('delete', $ticket);

        $ticketReplyImages = $ticket->replies()->with('images')->get();

        $ticketAndReplyImages = $this->complaintService
            ->collectTicketAndTicketRepliesImages(
                $ticket->images,
                $ticketReplyImages
            );

        if (!empty($ticketAndReplyImages) ) {

            $this->fileService->deleteMultiImages($ticketAndReplyImages);
        }

        $this->complaintService->deleteTicket($ticket);

        $this->loggingService->success('ticket complaint deleted successfully',[

            'ticket_title' => $ticket->subject,
        ]);

        return back()->with('success', 'the ticket has been colsed successfully');

} catch (\Exception $e) {

    $this->loggingService->failed('Error occurred while  deleting complaint ticket',[

        'ticket_title' => $ticket->subject,
        'exception_details' => $e->getMessage(),
    ]);

}

    }


}
