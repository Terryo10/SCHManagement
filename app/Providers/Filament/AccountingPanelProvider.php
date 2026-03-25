<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AccountingPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('accounting')
            ->path('accounting')
            ->login()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->brandName('Finance Portal')
            ->discoverResources(in: app_path('Filament/Accounting/Resources'), for: 'App\\Filament\\Accounting\\Resources')
            ->discoverPages(in: app_path('Filament/Accounting/Pages'), for: 'App\\Filament\\Accounting\\Pages')
            ->discoverWidgets(in: app_path('Filament/Accounting/Widgets'), for: 'App\\Filament\\Accounting\\Widgets')
            ->pages([Pages\Dashboard::class])
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('Fees')->icon('heroicon-o-banknotes'),
                NavigationGroup::make('Invoices & Payments')->icon('heroicon-o-document-currency-dollar'),
                NavigationGroup::make('Expenses')->icon('heroicon-o-arrow-trending-down'),
                NavigationGroup::make('Payroll')->icon('heroicon-o-currency-dollar'),
                NavigationGroup::make('Reports')->icon('heroicon-o-chart-bar'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
