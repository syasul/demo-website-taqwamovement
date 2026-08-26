<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Event;
use App\Models\Post;
use App\Observers\EventObserver;
use App\Observers\PostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\PaymentGatewayInterface::class,
            \App\Services\Payments\MidtransGateway::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::observe(EventObserver::class);
        Post::observe(PostObserver::class);
    }
}
