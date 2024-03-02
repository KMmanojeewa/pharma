<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
//        Gate::before(function($user, $ability) {
//            if ($user->role_id == 1) {
//                return true;
//            }
//        });

        //user
        Gate::define('read-create-update-delete-user', function (User $user) {
            if ($user->role_id == 1) {
                return true;
            }
        });

        //product
        Gate::define('create-delete-product', function (User $user) {
            if ($user->role_id == 1) {
                return true;
            }
        });

        Gate::define('soft-delete-product', function (User $user) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                return true;
            }
        });

        Gate::define('update-product', function (User $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3) {
                return true;
            }
        });

        //customer
        Gate::define('create-delete-customer', function (User $user) {
            if ($user->role_id == 1) {
                return true;
            }
        });

        Gate::define('soft-delete-customer', function (User $user) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                return true;
            }
        });

        Gate::define('update-customer', function (User $user) {
            if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3) {
                return true;
            }
        });
    }
}
