<?php

namespace ChingShop\Modules\Catalogue\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use View;

/**
 * Class CatalogueServiceProvider.
 */
class CatalogueServiceProvider extends ServiceProvider
{
    /**
     * Additional Compiled Module Classes.
     *
     * Here you may specify additional classes to include in the compiled file
     * generated by the `artisan optimize` command. These should be classes
     * that are included on basically every request into the application.
     *
     * @return array
     */
    public static function compiles()
    {
        return [];
    }

    /**
     * Register the Catalogue module service provider.
     *
     * This service provider is a convenient place to register your modules
     * services in the IoC container. If you wish, you may make additional
     * methods or service providers to keep the code more focused and granular.
     *
     * @return void
     */
    public function register()
    {
        App::register(
            'ChingShop\Modules\Catalogue\Providers\RouteServiceProvider'
        );

        /* @noinspection RealpathOnRelativePathsInspection */
        View::addNamespace(
            'catalogue',
            app_path('Modules/Catalogue/Resources/Views')
        );
    }

    /**
     * Bootstrap the application events.
     *
     * Here you may register any additional middleware provided with your
     * module with the following addMiddleware() method. You may pass in
     * either an array or a string.
     *
     * @return void
     */
    public function boot()
    {
    }
}
