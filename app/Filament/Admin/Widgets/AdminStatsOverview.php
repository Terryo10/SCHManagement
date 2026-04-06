<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Student;
use App\Models\Staff;
use App\Models\FeePayment;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $monthlyRevenue = FeePayment::whereMonth('paid_at', Carbon::now()->month)->sum('amount');
        
        $totalStudents = Student::count();
        $totalStaff = Staff::count();
        
        $presentToday = Attendance::whereDate('attendance_date', Carbon::today())
            ->whereIn('status', ['present', 'late']) // Assuming 'present' and 'late' count as attended
            ->count();
        
        $attendancePercentage = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0;

        return [
            Stat::make('Total Students', number_format($totalStudents))
                ->icon('heroicon-o-users')
                ->color('primary') // Indigo in our theme
                ->description('+4.2% vs last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Total Staff', number_format($totalStaff))
                ->icon('heroicon-o-academic-cap')
                ->color('success') // Emerald
                ->description('+1.1% vs last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Monthly Revenue', 'R ' . number_format($monthlyRevenue, 2))
                ->icon('heroicon-o-wallet')
                ->color('warning') // Amber
                ->description('+12.5% vs last month')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Today\'s Attendance', $attendancePercentage . '%')
                ->icon('heroicon-o-check-badge')
                ->color('danger') // Rose
                ->description('-0.8% vs last month')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
        ];
    }
}
