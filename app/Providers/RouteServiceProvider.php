<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O namespace para as rotas do controlador.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Registre as rotas da aplicação.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            // As rotas da web (geralmente para views)
            Route::prefix('web')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // As rotas da API (geralmente para JSON)
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Registre as rotas de aplicativo.
     *
     * @return void
     */
    public function map()
    {
        // Registra as rotas da API
        $this->mapApiRoutes();

        // Registra as rotas da web
        $this->mapWebRoutes();
    }

    /**
     * Registra as rotas da API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // Prefixo "api" para rotas de API
             ->middleware('api') // Middleware "api" para rotas de API
             ->namespace($this->namespace) // Namespace para os controladores
             ->group(base_path('routes/api.php')); // Arquivo de rotas de API
    }

    /**
     * Registra as rotas da web.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') // Middleware "web" para rotas da web
             ->namespace($this->namespace) // Namespace para os controladores
             ->group(base_path('routes/web.php')); // Arquivo de rotas da web
    }
}
