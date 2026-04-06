<?php

namespace App\Filament\Admin\Widgets;

use App\Models\FeePayment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentFeePaymentsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FeePayment::query()->latest('paid_at')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('studentFee.student.user.name')
                    ->label('Student')
                    ->description(fn (FeePayment $record): string => $record->transaction_ref ?? 'N/A')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                    
                // We'll use admission number instead of Class to keep query simple, or just a mock if not available
                Tables\Columns\TextColumn::make('studentFee.student.admission_number')
                    ->label('Admission No.')
                    ->searchable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('ZAR') // Using ZAR for Rands as seen in prompt
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('gateway')
                    ->label('Gateway')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success', // Emerald
                        'pending' => 'warning', // Amber
                        'failed' => 'danger', // Rose
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Date')
                    ->dateTime()
                    ->color('gray'),
            ])
            ->actions([
                Tables\Columns\Layout\View::make(false), // Optional placeholder
            ])
            ->paginated(false);
    }
}
