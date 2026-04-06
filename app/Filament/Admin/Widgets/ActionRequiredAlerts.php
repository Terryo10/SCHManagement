<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class ActionRequiredAlerts extends Widget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = ['sm' => 'full', 'md' => 1];
    protected static string $view = 'filament.admin.widgets.action-required-alerts';
    
    // You can declare columns if passing dynamic data to view
}
