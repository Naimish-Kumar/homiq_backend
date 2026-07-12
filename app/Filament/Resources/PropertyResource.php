<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Platform Data';
    
    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'address', 'owner.name'];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Property Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('title')->required(),
                                    Forms\Components\Select::make('owner_id')
                                        ->relationship('owner', 'name')
                                        ->required()
                                        ->searchable(),
                                    Forms\Components\TextInput::make('price')->required()->numeric()->prefix('$'),
                                    Forms\Components\Select::make('category')
                                        ->options([
                                            'Apartment' => 'Apartment',
                                            'Villa' => 'Villa',
                                            'House' => 'House',
                                            'Commercial' => 'Commercial',
                                        ])->required(),
                                    Forms\Components\Select::make('status')
                                        ->options([
                                            'active' => 'Active',
                                            'pending' => 'Pending Approval',
                                            'rejected' => 'Rejected',
                                            'rented' => 'Rented/Sold',
                                        ])->required(),
                                    Forms\Components\TextInput::make('listing_type')->required(),
                                ]),
                                Forms\Components\Textarea::make('description')->required()->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Location')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('address')->required()->columnSpanFull(),
                                    Forms\Components\TextInput::make('latitude')->numeric(),
                                    Forms\Components\TextInput::make('longitude')->numeric(),
                                    Forms\Components\TextInput::make('country'),
                                ])
                            ]),
                        Forms\Components\Tabs\Tab::make('Features')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('bedrooms')->numeric()->default(0),
                                    Forms\Components\TextInput::make('bathrooms')->numeric()->default(0),
                                    Forms\Components\TextInput::make('carpet_area')->numeric(),
                                    Forms\Components\Toggle::make('is_furnished'),
                                    Forms\Components\Toggle::make('has_parking'),
                                    Forms\Components\Toggle::make('is_pet_friendly'),
                                    Forms\Components\Toggle::make('is_featured'),
                                    Forms\Components\Toggle::make('is_negotiable'),
                                ])
                            ]),
                        Forms\Components\Tabs\Tab::make('Media & Amenities')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->multiple()
                                    ->image()
                                    ->directory('properties')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('amenities')->columnSpanFull(),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(30),
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'rented' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(\App\Filament\Exports\PropertyExporter::class)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()
                        ->exporter(\App\Filament\Exports\PropertyExporter::class),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
