<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\FeePayment;
use Carbon\Carbon;

class FeeCollectionChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Fee Collection History';
    
    // We want the chart to take more space, similar to the mockup
    protected int | string | array $columnSpan = ['sm' => 'full', 'md' => 2];
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Mocking the last 7 months of data based on the provided React design
        // In a real application, you would query the FeePayment model grouped by month.
        
        return [
            'datasets' => [
                [
                    'label' => 'Total Collected (ZAR)',
                    'data' => [40000, 60000, 45000, 80000, 65000, 90000, 85000],
                    'backgroundColor' => '#4f46e5', // Tailwind indigo-600
                    'borderRadius' => 4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
