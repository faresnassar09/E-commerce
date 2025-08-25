<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order\Order;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('seller.name')
                    ->label('Seller Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Total Amount (AED) '),

                    TextColumn::make('payment_method')
                    ->label('Payment Method'),

                    TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('userAddress')
                    ->label('Order Address')
                    ->formatStateUsing(function ($record) {

                        return $record?->userAddress?->city->name . '/' .
                            $record?->userAddress?->area->name . '/' .
                            $record?->userAddress?->street;
                    }),


                    TextColumn::make('comments')
                    ->label('Comments'),
               
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        switch ($record->status) {

                            case 0:
                                return 'preparing';
                            case 1:
                                return 'delivered';
                            case 2:
                                return 'canceled';
                            case 3:
                                return 'request To return';
                            case 4:
                                return 'rejected To Return';
                            case 5:
                                return 'returned';
                        }
                    })
                    ->sortable(),
                ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            
                Tables\Actions\Action::make('toggleStatus')
                    ->label(fn ($record) => $record->status === 2 ? 'Canceled' : 'Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color(fn ($record) => $record->status === 2 ? 'gray' : 'danger')
                    ->disabled(fn ($record) => $record->status === 2)
                    ->extraAttributes(fn ($record) => $record->status === 2
                        ? ['class' => 'opacity-50 cursor-not-allowed']
                        : [])
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 2]);
                    })
                    ->successNotificationTitle('✅ Order has been canceled'),
                ])
            
            
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([


            RepeatableEntry::make('items')
            ->label('Items')
            ->schema([
                ImageEntry::make('product.images.0.path')
                ->size(50)
                ->circular(),
                TextEntry::make('product.name')->label('Name'),
                TextEntry::make('quantity')->label('Quantity'),
                TextEntry::make('price')->label('Total'),
            ])->grid(3),
            


        ])  ;
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    } 
    public static function canEdit(Model $record): bool
    {
        return false;      
    }

 
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),

        ];
    }
}
  