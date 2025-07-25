<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelFortifyContractsLoginViewResponse;
use AppHttpResponsesCustomLoginViewResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LaravelFortifyContractsLoginViewResponse::class,
            AppHttpResponsesCustomLoginViewResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
