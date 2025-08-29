<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\DateRangeFilter;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use BackedEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'الطلبات';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('product.name')->label('Product')->sortable()->searchable(),
                TextColumn::make('customer_name')->label('العميل')->searchable(),
                TextColumn::make('phone')->label('الهاتف'),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->enum(array_combine(array_map(fn($c)=>$c->value, OrderStatus::cases()), array_map(fn($c)=>ucfirst($c->name), OrderStatus::cases())))
                    ->colors([
                        'warning' => OrderStatus::New->value,
                        'success' => OrderStatus::Confirmed->value,
                        'info' => OrderStatus::Shipped->value,
                        'danger' => OrderStatus::Canceled->value,
                    ]),
                TextColumn::make('created_at')->label('أنشئ في')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(fn () => collect(OrderStatus::cases())->mapWithKeys(fn($c) => [$c->value => ucfirst($c->name)])->toArray()),

                DateRangeFilter::make('created_at')->label('تاريخ الإنشاء'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('تصدير Excel')
                    ->action(function (array $data, $livewire) {
                        $query = $livewire->getQuery();
                        $export = new OrdersExport($query);
                        return Excel::download($export, 'orders.xlsx');
                    }),
            ])
            ->bulkActions([
                BulkAction::make('changeStatus')
                    ->label('تغيير الحالة')
                    ->form([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(fn () => collect(OrderStatus::cases())->mapWithKeys(fn($c) => [$c->value => ucfirst($c->name)])->toArray())
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data): void {
                        foreach ($records as $record) {
                            $record->update(['status' => $data['status']]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
