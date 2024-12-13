<?php

namespace App\Providers;

use App\Http\Middleware\HandleSubdomain;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
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
    public function boot(Router $router)
    {
        $router->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
        $router->aliasMiddleware('validate-subdomain', \App\Http\Middleware\ValidateSubdomain::class);
        $this->app->make(\Illuminate\Contracts\Http\Kernel::class)->pushMiddleware(HandleSubdomain::class);
    }
}
