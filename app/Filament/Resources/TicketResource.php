<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Support\Ticket;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

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


     
                               
                TextColumn::make('subject')
                    ->label('Subject'),


                TextColumn::make('message')
                    ->label('Details'),

                TextColumn::make('seller.name')
                    ->label('Seller Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('seller.email')
                    ->label('Seller Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('seller.phone_numbers')
                    ->label('Seller Phone')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('deleteWithImages')
                ->label('🗑️ حذف شامل')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $images = $record->replies->flatMap->images->merge($record->images);
            
                    app(\App\Services\FileServices::class)->deleteMultiImages($images);
            
                    $record->delete();
                }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

 public static function canCreate():bool{

return false;

 }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'view' => Pages\view::route('/{record}/view'),
        ];
    }
}
