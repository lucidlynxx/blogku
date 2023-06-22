<?php

namespace App\Providers;

use Filament\Facades\Filament;
use App\Filament\Pages\MyProfile;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(MyProfile::getUrl()),
            ]);
        });
    }
}
