<?php

namespace App\Providers;

use Shared\Enums\MorphEnum;
use Domain\Client\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Paginator::useBootstrap();

        JsonResource::withoutWrapping();

        $this->loadMigrationsFrom([
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Client',
            database_path() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'Product',
        ]);

        Relation::morphMap([
            MorphEnum::USER->value => User::class,
        ]);

        if ($this->app->environment(['local', 'staging', 'testing'])) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        } elseif ($this->app->environment(['production'])) {
            app(\Illuminate\Routing\UrlGenerator::class)->forceScheme('https');
        }
    }
}
