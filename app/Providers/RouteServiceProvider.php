<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\Comment;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Users are typically redirected here after login.
     *
     * @var string
     */
    public const HOME = '/profile'; // Ubah ke '/profile' jika kamu ingin redirect ke profil

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
        {
            parent::boot();

            Route::model('comment', Comment::class); // tambahkan ini
        }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
    
}
