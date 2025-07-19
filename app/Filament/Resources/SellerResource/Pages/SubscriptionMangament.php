<?php

namespace App\Filament\Resources\SellerResource\Pages;

use App\Filament\Resources\SellerResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class SubscriptionMangament extends Page
{
    use InteractsWithRecord;

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
    protected static string $resource = SellerResource::class;

    protected static string $view = 'filament.resources.seller-resource.pages.subscription-mangament';
    
    
    public function cancelSubscription()
    {

 if(!$this->record?->subscription()->ends_at != null){

$this->record->subscription()->cancel();

 }





    }

}
