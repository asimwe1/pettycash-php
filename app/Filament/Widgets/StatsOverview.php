<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Facades\Filament;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $query = Transaction::query();

        if (Filament::getCurrentPanel()->getId() === 'portal') {
            $query->where('user_id', auth()->id());
        }

        $income = (clone $query)->where('type', 'in')->sum('amount');
        $expense = (clone $query)->where('type', 'out')->sum('amount');
        $balance = $income - $expense;

        return [
            Stat::make('Total Balance', '$' . number_format($balance, 2))
                ->description('Net cash on hand')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($balance >= 0 ? 'success' : 'danger'),
            Stat::make('Total Income', '$' . number_format($income, 2))
                ->description('All "In" transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Expenses', '$' . number_format($expense, 2))
                ->description('All "Out" transactions')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
