<?php

namespace Due\Fast\Providers;

use Dingo\Api\Http\Parser\Accept;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * 路由服务提供者
 * @package Due\Fast\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    use ForwardsCalls;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../../config/route.php' => config_path('route.php')
        ], 'config');

        $this->setRootControllerNamespace();

        if ($this->routesAreCached()) {
            $this->loadCachedRoutes();
        } else {
            $this->loadRoutes();

            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    public function register()
    {
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/route.php', 'route'
        );
    }

    /**
     * Set the root controller namespace for the application.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        if (!is_null(config('route.namespace', null))) {
            $this->app[UrlGenerator::class]->setRootControllerNamespace(config('route.namespace', null));
        }
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    protected function routesAreCached()
    {
        return $this->app->routesAreCached();
    }

    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $this->app->booted(function () {
            require $this->app->getCachedRoutesPath();
        });
    }

    /**
     * Load the application routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        if (method_exists($this, 'map')) {
            $this->app->call([$this, 'map']);
        }
    }

    /**
     * 映射
     */
    public function map()
    {
//        $this->mapApiRoutes();
//
//        $this->mapAdminRoutes();
//
//        $this->mapWebRoutes();
    }

//    /**
//     * 映射web路由
//     */
//    protected function mapWebRoutes()
//    {
//        Route::middleware('web')
//            ->namespace($this->namespace)
//            ->group(base_path('routes/web.php'));
//    }
//
//    /**
//     * 映射api路由
//     */
//    protected function mapApiRoutes()
//    {
//        $accept = (new Accept(
//            config('api.standardsTree'),
//            config('api.subtype'),
//            config('api.version'),
//            config('api.defaultFormat')
//        ))->parse(request());
//
//        $routeFile = $accept['version'] . '.php';
//
//        Route::prefix('api')
//            ->middleware('api')
//            ->namespace($this->namespace)
//            ->group(base_path('routes/api/' . $routeFile));
//    }
//
//    /**
//     * 映射admin路由
//     */
//    protected function mapAdminRoutes()
//    {
//        $accept = (new Accept(
//            config('api.standardsTree'),
//            config('api.subtype'),
//            config('api.version'),
//            config('api.defaultFormat')
//        ))->parse(request());
//
//        $routeFile = $accept['version'] . '.php';
//
//        Route::prefix('admin')
//            ->middleware('api')
//            ->namespace($this->namespace)
//            ->group(base_path('routes/admin/' . $routeFile));
//    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo(
            $this->app->make(Router::class), $method, $parameters
        );
    }
}