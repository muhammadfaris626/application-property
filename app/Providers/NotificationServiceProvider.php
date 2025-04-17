<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.app.sidebar', function($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->unreadNotifications;
                $view->with([
                    'notifAll' => $notifications->count(),
                    'notifList' => $notifications
                ]);
            }
        });
    }
}
