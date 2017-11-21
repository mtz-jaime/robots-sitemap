<?php

namespace MtzJaime\RobotsSitemap;

use Illuminate\Support\ServiceProvider;

class RobotsSitemapServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views/', 'sitemap');
        $this->publishes([__DIR__ . '/config/robotsAgents.php' => config_path('robotsAgents.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/web.php';
        $this->app->make('MtzJaime\RobotsSitemap\PackageController');
    }
}
