<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationResource\Pages;
use App\Filament\Resources\ConfigurationResource\RelationManagers;
use App\Models\Configuration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationResource extends Resource
{
    protected static ?string $model = Configuration::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationGroup = 'Website Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configuration Details')
                    ->description('Manage system settings, themes, and API keys securely.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('label')
                                ->label('Friendly Name')
                                ->required()
                                ->placeholder('e.g., SMTP Host')
                                ->prefixIcon('heroicon-o-tag'),
                            Forms\Components\TextInput::make('key')
                                ->label('System Key')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->placeholder('e.g., smtp_host')
                                ->helperText('The exact key used by the application code.')
                                ->prefixIcon('heroicon-o-code-bracket'),
                            Forms\Components\TextInput::make('group')
                                ->label('Settings Group')
                                ->required()
                                ->placeholder('e.g., general, smtp, theme')
                                ->prefixIcon('heroicon-o-folder'),
                            Forms\Components\Select::make('type')
                                ->label('Input Type')
                                ->options([
                                    'text' => 'Text',
                                    'textarea' => 'Textarea',
                                    'boolean' => 'Boolean (True/False)',
                                    'json' => 'JSON Data',
                                ])
                                ->required()
                                ->default('text')
                                ->prefixIcon('heroicon-o-adjustments-horizontal'),
                        ]),
                        Forms\Components\Textarea::make('value')
                            ->label('Configuration Value')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Admin Notes / Description')
                            ->helperText('Context for other administrators on what this setting controls.')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Setting')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->description(fn (Configuration $record): string => $record->key),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Value copied to clipboard'),
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])
            ->defaultGroup('group')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConfigurations::route('/'),
            'create' => Pages\CreateConfiguration::route('/create'),
            'edit' => Pages\EditConfiguration::route('/{record}/edit'),
        ];
    }
}
