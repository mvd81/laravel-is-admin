<?php

namespace Mvd81\LaravelIsAdmin;

use File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mvd81\LaravelIsAdmin\Http\Middleware\IsAdmin;

class LaravelIsAdminServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {

        // Add 'is_admin' column to the users table.
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Register Blade directive component.
        Blade::if('isAdmin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Register the IsAdmin middleware.
        $router = $this->app['router'];
        $router->aliasMiddleware('IsAdmin', 'Mvd81\LaravelIsAdmin\Http\Middleware\IsAdmin');

        // Publish the config file to the Laravel config directory.
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/is_admin.php' => config_path('is_admin.php'),
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        // Register the artisan command.
        $commands = [
            'Mvd81\LaravelIsAdmin\Console\Commands\IsAdminList'
        ];

        $this->commands($commands);
    }
}
