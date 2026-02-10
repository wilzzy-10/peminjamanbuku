<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;

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
        // Register policies
        \Illuminate\Support\Facades\Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);

        // Use bootstrap pagination
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Register route model bindings
        Route::model('book', Book::class);
        Route::model('loan', Loan::class);
        Route::model('user', User::class);
    }
}
