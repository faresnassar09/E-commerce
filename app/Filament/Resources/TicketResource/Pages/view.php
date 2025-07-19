<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Support\TicketReply;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TicketResource\Widgets\Ticket;

class view extends ViewRecord
{
    protected static string $resource = TicketResource::class;


    public function getHeaderActions(): array
{
    return [
        Action::make('reply')
            ->form([
                Textarea::make('message')->required(),
            ])
            ->action(function (array $data) {
                TicketReply::create([
                    'ticket_id' => $this->record->id,
                    'message' => $data['message'],
                    'sender_type' => 'admin',
                ]);
            })
            ->label('رد على التذكرة'),
    ];
}  

protected function getFooterWidgets(): array
{
    return [
        Ticket::make(['record' => $this->record]),
    ];
}
}
