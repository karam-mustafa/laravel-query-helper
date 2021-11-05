<?php

namespace KMLaravel\QueryHelper\Providers;

use Illuminate\Support\ServiceProvider;
use KMLaravel\QueryHelper\Classes\QueryHelper;

class QueryHelperServiceProviders extends ServiceProvider
{

    public function boot()
    {
        $this->registerFacades();
        $this->publishesPackages();
    }

    public function register()
    {
    }

    /**
     *
     */
    protected function registerFacades()
    {
        $this->app->singleton("QueryHelperFacade", function ($app) {
            return new QueryHelper();
        });
    }

    /**
     * @desc publish files
     * @author karam mustafa
     */
    protected function publishesPackages()
    {
        $this->publishes([
            __DIR__."/../Config/query_helper.php" => config_path("query_helper.php")
        ], "query-helper-config");
    }

}
