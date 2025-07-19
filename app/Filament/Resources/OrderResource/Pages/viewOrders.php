<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;

class viewOrders extends ViewRecord
{
    protected static string $resource = OrderResource::class;





        protected function getFormSchema(): array
{
    return [
        TextEntry::make('id')->label('معرّف الطلب'),
        TextEntry::make('created_at')->label('تاريخ الإنشاء'),
    ];
}
    }


