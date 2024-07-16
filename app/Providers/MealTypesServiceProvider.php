<?php

namespace App\Providers;

use App\Constants\MealTypes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class MealTypesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('mealTypes', MealTypes::all());
        });    }
}
