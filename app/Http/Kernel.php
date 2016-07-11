<?php

namespace ChingShop\Http;

use Fideloper\Proxy\TrustProxies;
use GrahamCampbell\HTMLMin\Http\Middleware\MinifyMiddleware;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Class Kernel
 *
 * @package ChingShop\Http
 */
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            TrustProxies::class,
            Middleware\ForceSecure::class,
            Middleware\EncryptCookies::class,

            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,

            Middleware\VerifyCsrfToken::class,

            MinifyMiddleware::class,
        ],
        'api' => [
            TrustProxies::class,
            Middleware\ForceSecure::class,
            'throttle:60,1',
            'auth:api',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => Middleware\Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest'      => Middleware\RedirectIfAuthenticated::class,
        'staff'      => Middleware\StaffOnly::class,
        'customer'   => Middleware\Customer::class,
    ];
}
