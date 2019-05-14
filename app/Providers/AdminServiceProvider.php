<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\Admin\Bouncer;
use App\Http\Tree;

class AdminServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot(Router $router)
    {
        $router->aliasMiddleware('admin', Bouncer::class);
        $this->composeView();
    }

    protected function composeView()
    {
        view()->composer(['admin.layouts.aside','admin.layouts.breadcrumb'], function ($view) {
            $tree = Tree::create();

            foreach (config('menu') as $item) {
                $tree->add($item, 'menu');
                //pending: 有待补充权限逻辑
            }

            $tree->items = $tree->sortItems($tree->items);
            $view->with('menu', $tree);
        });
    }
}
