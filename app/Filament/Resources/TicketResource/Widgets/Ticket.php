<?php

namespace App\Filament\Resources\TicketResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Widget
{
    protected static string $view = 'filament.resources.ticket-resource.widgets.ticket';

    public ?Model $record = null;

    public function ticketImages()
    {
        return $this->record->images()->get();
    }

    public function getReplies()
    {
        return $this->record->replies()->with('images')->latest()->get();
    }


}
