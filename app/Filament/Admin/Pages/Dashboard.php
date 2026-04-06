<?php

namespace App\Filament\Admin\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    /**
     * @return int | string | array<string, int | string | null>
     */
    public function getColumns(): int | string | array
    {
        return [
            'md' => 3,
            'xl' => 3,
        ];
    }
}
