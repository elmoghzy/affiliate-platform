<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use BackedEnum;
use Outerweb\FilamentTranslatableFields\Forms\Components\Translatable;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'المنتجات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Translatable::make(
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                )->label('الاسم'),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Translatable::make(
                    Forms\Components\Textarea::make('description')
                        ->rows(3)
                        ->maxLength(65535)
                )->label('الوصف'),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),

                Forms\Components\FileUpload::make('image_path')
                    ->directory('products')
                    ->image()
                    ->nullable(),

                Translatable::make(
                    Forms\Components\TextInput::make('category')
                        ->nullable()
                        ->maxLength(255)
                )->label('التصنيف'),

                Forms\Components\Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->label('السعر')->money('EGP')->sortable(),
                Tables\Columns\TextColumn::make('category')->label('التصنيف')->searchable(),
                Tables\Columns\BooleanColumn::make('is_active')->label('نشط')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('إنشئ في')->dateTime()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('نشط'),
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options(fn () => Product::query()->whereNotNull('category')->distinct()->pluck('category', 'category')->toArray()),
            ])
            ->defaultSort('created_at', 'desc');
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
