<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalUsers = \App\Models\User::count();
        $totalProperties = \App\Models\Property::count();
        $totalBookings = \App\Models\Booking::count();
        $totalRevenue = \App\Models\Booking::whereIn('status', ['approved', 'completed'])->sum('platform_fee');

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Active members')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Properties', $totalProperties)
                ->description('Listings on platform')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('success'),
            Stat::make('Total Bookings', $totalBookings)
                ->description('All time reservations')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Total Revenue', '₹ ' . number_format($totalRevenue, 2))
                ->description('Platform fees earned')
                ->descriptionIcon('heroicon-m-currency-rupee')
                ->color('warning'),
        ];
    }
}
