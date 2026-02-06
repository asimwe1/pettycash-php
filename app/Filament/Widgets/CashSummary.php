<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CashSummary extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $currentBalance = Transaction::where('type', 'in')->sum('amount') - Transaction::where('type', 'out')->sum('amount');
        
        $spendingThisMonth = Transaction::where('type', 'out')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('amount');

        $lastReplenishment = Transaction::where('type', 'in')
            ->latest('date')
            ->first();

        return [
            Stat::make('Current Balance', '$' . number_format($currentBalance, 2))
                ->icon('heroicon-o-wallet')
                ->color('success'),
            
            Stat::make('Spending this Month', '$' . number_format($spendingThisMonth, 2))
                ->icon('heroicon-o-arrow-trending-down')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3])
                ->color('danger'),
            
            Stat::make('Last Replenishment', $lastReplenishment ? Carbon::parse($lastReplenishment->date)->diffForHumans() : 'No transactions')
                ->icon('heroicon-o-arrow-path')
                ->color('gray'),
        ];
    }
}
