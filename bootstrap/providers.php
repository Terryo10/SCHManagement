<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\AccountingPanelProvider;
use App\Providers\Filament\ParentPanelProvider;
use App\Providers\Filament\StudentPanelProvider;
use App\Providers\Filament\TeacherPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    TeacherPanelProvider::class,
    StudentPanelProvider::class,
    AccountingPanelProvider::class,
    ParentPanelProvider::class,
];
