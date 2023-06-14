<?php

namespace App\Providers;

use App\Filament\Resources\Account\AccountResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;

use App\Filament\Resources\Customer\CustomerResource;
use App\Filament\Resources\Leave\LeaveResource;
use App\Filament\Resources\User\UserResource;
use Filament\Navigation\NavigationGroup;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                'logout' => UserMenuItem::make()->url(route('logout')),
            ]);

            // Using Vite
            Filament::registerViteTheme('resources/css/app.css');

        });
        
        // Sidebar Navigation
        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $user = auth()->user();
            $update_password_url = UserResource::getUrl('edit', ['record' => $user->id]);
            return $builder->groups([
                NavigationGroup::make('')
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->url(route('filament.pages.dashboard'))
                            ->icon('heroicon-o-home')
                            ->activeIcon('heroicon-s-home')
                            ->isActiveWhen(fn(): bool => request()->routeIs('filament.pages.dashboard')),
                    ]),
                NavigationGroup::make('')
                    ->items([
                        // ...CustomerResource::getNavigationItems(),
                        ...LeaveResource::getNavigationItems()
                    ]),
                NavigationGroup::make('Settings')
                    ->items([
                        $user->can('update-password') ?
                        NavigationItem::make('Update Personal Information')
                                ->url($update_password_url)
                                ->icon('heroicon-o-cog')
                                ->activeIcon('heroicon-s-cog')
                                ->isActiveWhen(fn() : bool => request()->fullUrl() == $update_password_url) : null,
                    ]),
                $user->can('update-password') ? 
                    NavigationGroup::make('Admin')
                        ->items([
                            ...AccountResource::getNavigationItems()

                                // NavigationItem::make('Account Management')
                                //     ->url($update_password_url)
                                //     ->icon('heroicon-o-cog')
                                //     ->activeIcon('heroicon-s-cog')
                                //     ->isActiveWhen(fn() : bool => request()->fullUrl() == $update_password_url)
                        ]): null
            ]);
        });
    }
}
