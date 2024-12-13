<?php

namespace Mvd81\LaravelIsAdmin\Test;

use Mvd81\LaravelIsAdmin\Test\Models\User;

use Illuminate\Database\Schema\Blueprint;
use Mvd81\LaravelIsAdmin\Http\Middleware\IsAdmin;
use Mvd81\LaravelIsAdmin\LaravelIsAdminServiceProvider;
use Symfony\Component\Routing\Route;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Note: this also flushes the cache from within the migration
        $this->createDatabase($this->app);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('view.paths', [__DIR__.'/resources/views']);

        // Use test User model for users provider
        $app['config']->set('auth.providers.users.model', User::class);

        // Register the IsAdmin middleware to the app.
        $app['router']->aliasMiddleware('IsAdmin', 'Mvd81\LaravelIsAdmin\Http\Middleware\IsAdmin');

        $app['router']->get('admin-route', function () {
            return 'admin page';
        })->middleware('IsAdmin');

        $app['router']->get('login', function () {
            return 'login form';
        })->name('login');

        $app['router']->get('blade', function () {
            return view('dummy');
        });
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelIsAdminServiceProvider::class
        ];
    }

    /**
     * Create a test users database table.
     */
    protected function createDatabase($app) {

        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(0);
            $table->timestamps();
        });
    }
}
