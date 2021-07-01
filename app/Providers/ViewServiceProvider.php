<?php

namespace App\Providers;

use App\Services\DynamicMailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
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
        $domain = DynamicMailer::getDomain();

        View::share('domain', $domain);
    }
}
