<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use EightCedars\FilamentInactivityGuard\FilamentInactivityGuardPlugin;
use Monzer\FilamentEmailVerificationAlert\EmailVerificationAlertPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use App\Filament\Resources\UserResource;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use App\Livewire\CustomProfileComponent;
use Kenepa\ResourceLock\ResourceLockPlugin;
use Kenepa\Banner\BannerPlugin;
use Monzer\FilamentChatifyIntegration\ChatifyPlugin;
use Brickx\MaintenanceSwitch\MaintenanceSwitchPlugin;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use App\Filament\Resources\TaskListResource;
use App\Filament\Resources\MeetingResource;
use App\Filament\Resources\AnnouncementResource;
use Psy\Readline\Hoa\EventSource;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\FilamentMails\Resources\SuppressionResource;
use Z3d0X\FilamentLogger\Resources\ActivityResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ->default()
            ->id('admin')
            ->path('into')
            ->login()
            ->colors([
                'primary' => '#00BFFF',   // Bright blue
                // 'gray' => '#0D1117',       // Dark background
                // 'background' => '#161B22', // Card background
                // 'text' => '#F0F6FC',       // Light text
                // 'muted' => '#8B949E',      // Muted gray
                // 'accent' => '#58A6FF',     // Highlight blue
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->theme(asset('css/filament/admin/theme.css'))
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                OverlookWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->routes(fn() => FilamentMails::routes())
            ->plugins([
                FilamentShieldPlugin::make(),
                EmailVerificationAlertPlugin::make(),
                FilamentInactivityGuardPlugin::make(),
                FilamentSpatieLaravelHealthPlugin::make(),
                // EnvironmentIndicatorPlugin::make(),
                FilamentBackgroundsPlugin::make(),
                FilamentMailsPlugin::make(),
                // FilamentGeneralSettingsPlugin::make(),
                FilamentEditProfilePlugin::make(),
                BannerPlugin::make(),
                // FilamentErrorPagesPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                ChatifyPlugin::make(),
                // MaintenanceSwitchPlugin::make(),
                EasyFooterPlugin::make(),
                FilamentProgressbarPlugin::make()->color('#29b'),
                OverlookPlugin::make()
                    ->sort(2)
                    ->excludes([
                        EventSource::class,
                        SuppressionResource::class,
                        ActivityResource::class,
                        EventResource::class,
                    ])

            ])
            ->resources([
                UserResource::class,
                config('filament-logger.activity_resource')
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
