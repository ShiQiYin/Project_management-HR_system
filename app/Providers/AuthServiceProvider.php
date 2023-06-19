<?php

namespace App\Providers;

use App\Models\Position;
use App\Models\Roles;
use App\Models\Team;
use App\Models\User;
use App\Policies\PositionPolicy;
use App\Policies\RolePolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Roles::class => RolePolicy::class,
        Position::class => PositionPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant all permissions to the "admin" role
        Gate::before(fn($user) => $user->hasRole('admin') ? true : null);
    }
}
