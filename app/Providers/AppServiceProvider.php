<?php

namespace App\Providers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
    public function boot()
    {
        Gate::define('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });

        Gate::define('view-account', function ($user, Account $account) {
            return $user->id === $account->client_id;
        });

        Gate::define('create-transaction', function ($user) {
            return $user !== null; // любой авторизованный пользователь
        });


        Paginator::useBootstrap();

    }
}
