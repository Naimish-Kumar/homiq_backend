<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $navigationGroup = 'Site Content';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Hero Carousel Slides';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Headline & Content')
                    ->description('Main text, badges, and headline displayed in the hero carousel')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Main Headline')
                            ->placeholder('e.g. Premium Plots Near Jewar Airport')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->placeholder('e.g. Invest in Your Future Today')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('badge_text')
                            ->label('Top Badge Text')
                            ->placeholder('e.g. Near Jewar International Airport'),

                        Forms\Components\TextInput::make('badge_icon')
                            ->label('Badge Icon (Material Symbol)')
                            ->placeholder('location_on')
                            ->default('location_on')
                            ->helperText('Material Symbol name: location_on, verified_user, trending_up, home_work, etc.'),

                        Forms\Components\TagsInput::make('highlights')
                            ->label('Feature Highlights (3-4 points)')
                            ->placeholder('Add highlight (press enter)')
                            ->helperText('e.g. High ROI, Government Approved, 100% Secure')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Background Image')
                    ->description('High resolution 16:9 panoramic photo for the slide')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Hero Slide Image')
                            ->image()
                            ->disk('public')
                            ->directory('images/hero')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Call-To-Action Buttons & Links')
                    ->schema([
                        Forms\Components\TextInput::make('primary_cta_text')
                            ->label('Primary Button Text')
                            ->default('Explore Projects')
                            ->required(),

                        Forms\Components\TextInput::make('primary_cta_link')
                            ->label('Primary Button URL')
                            ->default('/#listings')
                            ->required(),

                        Forms\Components\TextInput::make('secondary_cta_text')
                            ->label('Secondary Button Text')
                            ->default('Contact Us'),

                        Forms\Components\Select::make('secondary_cta_action')
                            ->label('Secondary Button Action')
                            ->options([
                                'request_modal' => 'Open Post Request / Contact Modal',
                                'url' => 'Navigate to Custom URL',
                            ])
                            ->default('request_modal'),

                        Forms\Components\TextInput::make('secondary_cta_link')
                            ->label('Secondary Button URL (if custom URL selected)')
                            ->default('javascript:void(0)'),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Ordering')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active on Website')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Preview')
                    ->circular(false)
                    ->width(120)
                    ->height(68),

                Tables\Columns\TextColumn::make('title')
                    ->label('Headline')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('badge_text')
                    ->label('Badge')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Sort')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
