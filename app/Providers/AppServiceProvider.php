<?php

namespace App\Providers;
use Filament;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Filament\Support\Colors\Color;
use Illuminate\Support\ServiceProvider;

use Filament\Notifications\Notification;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\View\Components\Modal;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Filament\Notifications\Notification as BaseNotification;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        // RATE LIMITER
//        RateLimiter::for('')

        Str::macro('acronym', function ($string) {
            $acronym = '';
            $words = explode(' ', $string);
            foreach ($words as $word) {
                $acronym .= strtoupper(substr($word, 0, 1));
            }
            return $acronym;
        });
        DatabaseNotifications::pollingInterval(null);

        Modal::closedByClickingAway(false);

        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::hex('#0059e8')    ,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'dangers' => Color::rgb('rgb(255, 0, 0)'),
        ]);

    }
}
