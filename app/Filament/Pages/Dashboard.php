<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\Repair;
use App\Models\User;
use App\Models\Message;
use Filament\Pages\Dashboard as FilamentDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Dashboard extends FilamentDashboard
{
    public function getStats(): array
    {
        $totalRevenue = Order::where('status', 'delivered')
            ->sum('total');
        
        $pendingRepairs = Repair::where('type', 'user')
            ->where('status', '!=', 'completed')
            ->count();
        
        $lowStockItems = Product::where('stock', '<', 5)->count();
        
        $totalUsers = User::count();

        return [
            Stat::make('Total Revenue', 'UGX ' . number_format($totalRevenue))
                ->color('success')
                ->icon('heroicon-o-banknotes'),
            
            Stat::make('Active Repairs', $pendingRepairs)
                ->color('warning')
                ->icon('heroicon-o-wrench-screwdriver'),
            
            Stat::make('Low Stock Alerts', $lowStockItems)
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
            
            Stat::make('Total Community', $totalUsers)
                ->color('info')
                ->icon('heroicon-o-users'),
        ];
    }
}
