<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function form(Form $form): Form
    {

        
        return $form
            ->schema([


             TextInput::make('name')
             ->label('Name'),
             
             TextInput::make('description')
             ->label('Description'),
             TextInput::make('price')
             ->label('Price'),
             TextInput::make('discount')
             ->label('Discount'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                ImageColumn::make('images')
                ->label('الصورة')
                ->getStateUsing(fn ($record) => $record->images->first()?->path ? asset('storage/' . $record->images->first()->path) : null)
                ->size(40),


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
            

            TextColumn::make('description')
                ->label('Description')
                ->sortable()
                ->searchable(),

            TextColumn::make('price')
                ->label('Price')
                ->sortable(),

            TextColumn::make('discount')
                ->label('Discount')
                ->sortable()
                ->searchable(),


            TextColumn::make('seller.name')
                ->label('Seller')
                ->sortable()
                ->searchable(),

            TextColumn::make('store.name')
                ->label('Store')
                ->sortable()
                ->searchable(), 


                TextColumn::make('status')
                ->label('status')
                ->formatStateUsing(fn($record) => $record->status ? 'Activated' : 'Disabled')
                ->html()
                ->sortable()
                ->searchable(), 

                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleStatus')
                ->label(fn ($record) => $record->status == 0 ? 'Enable' : 'Disable')
                ->icon(fn ($record) => $record->status == 0 ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn ($record) => $record->status == 0 ? 'success' : 'gray')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $newStatus = $record->status == 0 ? 1 : 0;
                    $record->update(['status' => $newStatus]);
                })
                ->successNotificationTitle(fn ($record) =>
                    $record->status == 0
                        ? '✅ Product Has Been Enabled'
                        : '🚫 Product Has Been Disabled'
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
