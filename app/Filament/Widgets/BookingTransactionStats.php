<?php

namespace App\Filament\Widgets;

use App\Models\BookingTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingTransactionStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalTransactions = BookingTransaction::count();
        $approvedTransactions = BookingTransaction::where('is_paid',true)->count();
        $totalRevenue = BookingTransaction::where('is_paid', true)->sum('total_amount');

        return [
            Stat::make('Total Transaction', $totalTransactions)
            ->description('All transactions')
            ->descriptionIcon('heroicon-o-currency-dollar'),

            Stat::make('Approved Transactions', $approvedTransactions)
            ->description('Approved transactions')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success'),

            Stat::make('Total Revenue', 'IDR' . number_format($totalRevenue))
            ->description('Revenue from approved transactions')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success'),
        ];
    }
}
