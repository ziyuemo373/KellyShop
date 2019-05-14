<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\Customer\RedirectIfNotCustomer;

class CustomerServiceProvider extends ServiceProvider
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
    public function boot(Router $router)
    {
        $router->aliasMiddleware('customer', RedirectIfNotCustomer::class);
    }
}
