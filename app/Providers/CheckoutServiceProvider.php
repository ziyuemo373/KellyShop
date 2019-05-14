<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use App\Http\Cart;
use App\Http\Payment;

class CheckoutServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacades();

        //设置所有bc数学函数的默认小数点保留位数
        bcscale(2);
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('cart', Cart::class);
        $loader->alias('payment', Payment::class);

        $this->app->singleton('cart', function () {
            return new Cart();
        });
        $this->app->singleton('payment', function () {
            return new Payment();
        });

        $this->app->bind('cart', 'App\Http\Cart');
        $this->app->bind('payment', 'App\Http\Payment');
    }
}