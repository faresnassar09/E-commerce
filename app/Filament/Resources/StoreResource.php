<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Models\Area;
use App\Models\City;
use App\Models\Store\Store;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                TextInput::make('name')
                    ->label('Name'),

                TextInput::make('description')
                    ->label('Description'),

                Select::make('city_id')
                    ->label('City')
                    ->options(City::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('area_id', null);
                    }),

                Select::make('area_id')
                    ->label('Area')
                    ->options(function (callable $get) {
                        $cityId = $get('city_id');
                        if (!$cityId) return [];

                        return Area::where('city_id', $cityId)->pluck('name', 'id');
                    })
                    ->reactive()
                    ->required(),

                TextInput::make('street')
                    ->label('Street')
                    ->required(),
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
                    ->label('name')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->status === 0
                            ? "<del class='text-red-600'>$state</del>"
                            : $state
                    )
                    ->html()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('description')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('seller.name')
                    ->label('seller')
                    ->sortable()
                    ->searchable(),


                TextColumn::make('full_address')
                    ->label('address')
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
                    ->label(fn($record) => $record->status == 0 ? 'Enable' : 'Disable')
                    ->icon(fn($record) => $record->status == 0 ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($record) => $record->status == 0 ? 'success' : 'gray')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $newStatus = $record->status == 0 ? 1 : 0;
                        $record->update(['status' => $newStatus]);
                    })
                    ->successNotificationTitle(
                        fn($record) =>
                        $record->status == 0
                            ? '✅  Store has been Enabled'
                            : '🚫 Store has been Disabled'
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
    public static function canCreate(): bool
    {

        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
