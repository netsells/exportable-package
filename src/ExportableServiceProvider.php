<?php

namespace Netsells\Exportable;

use Illuminate\Support\ServiceProvider;

class ExportableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/exportable.php' => config_path('exportable.php'),
            __DIR__.'/views' => base_path('resources/views/netslles/exportable'),
        ]);

//        $this->loadViewsFrom(__DIR__.'/views', 'exportable');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
