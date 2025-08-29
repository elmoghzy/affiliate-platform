<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\HeaderAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options(OrderStatus::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('المنتج')->searchable(),
                Tables\Columns\TextColumn::make('customer_name')->label('العميل')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف'),
                BadgeColumn::make('status')->label('الحالة')->colors([
                    'warning' => OrderStatus::New->value,
                    'success' => OrderStatus::Confirmed->value,
                    'info' => OrderStatus::Shipped->value,
                    'danger' => OrderStatus::Canceled->value,
                ]),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(OrderStatus::class)
            ])
            ->headerActions([
                HeaderAction::make('export')
                    ->label('Export to Excel')
                    ->action(function ($livewire) {
                        return Excel::download(new OrdersExport($livewire->getFilteredTableQuery()), 'orders.xlsx');
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('change_status')
                        ->label('تغيير الحالة')
                        ->action(function (Collection $records, array $data): void {
                            $records->each->update(['status' => $data['status']]);
                        })
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('الحالة الجديدة')
                                ->options(OrderStatus::class)
                                ->required(),
                        ])
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
