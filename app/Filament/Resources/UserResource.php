<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

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

                TextColumn::make('name')
                ->label('Name ')
                ->formatStateUsing(fn ($state, $record) =>
                    $record->status === 0
                        ? "<del class='text-red-600'>$state</del>"
                        : $state
                )
                ->html() 
                ->sortable()
                ->searchable(),
                 

             TextColumn::make('email')
             ->label('Email')
             ->sortable()
             ->searchable(),

             TextColumn::make('phone')
             ->label('Phone')
             ->sortable()
             ->searchable(),

             TextColumn::make('addresses.0')
             ->label('Addresses')
             ->formatStateUsing(function($record) 
             { return $record->addresses->first()->city?->name .'/'.$record->addresses->first()->area?->name .'/'.$record?->addresses?->first()->street;})
             ->sortable()
             ->searchable(),

             TextColumn::make('status')
             ->label('status')
             ->formatStateUsing(fn($record) => $record->status ? 'Unblocked' : 'Blocked')
             ->html()
             ->sortable()
             ->searchable(), 
  
                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('toggleStatus')
                ->label(fn ($record) => $record->status == 0 ? 'Unblock' : 'Block')
                ->icon(fn ($record) => $record->status == 0 ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn ($record) => $record->status == 0 ? 'success' : 'gray')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $newStatus = $record->status == 0 ? 1 : 0;
                    $record->update(['status' => $newStatus]);
                })
                ->successNotificationTitle(fn ($record) =>
                    $record->status == 0
                        ? '✅  User Unblocked'
                        : '🚫 User has been Blocked'
                ),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
