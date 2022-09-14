<?php

namespace PavanCs\Padmnabham;

use PavanCs\Padmnabham\Console\ConsoleMakeFacade;
use PavanCs\Padmnabham\Console\ConsoleMakeInterface;
use PavanCs\Padmnabham\Console\ConsoleMakeRepository;
use PavanCs\Padmnabham\Console\ServiceDesignPattern;

use Illuminate\Support\ServiceProvider;

class PadmnabhamServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            ConsoleMakeFacade::class,
            ConsoleMakeInterface::class,
            ConsoleMakeRepository::class,
            ServiceDesignPattern::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
            
                __DIR__ . '/Console/stubs/service.stub'       => base_path('stubs/service.stub'),
                __DIR__ . '/Console/stubs/facade.stub'       => base_path('stubs/facade.stub'),
                __DIR__ . '/Console/stubs/repository.stub'       => base_path('stubs/repository.stub'),
                __DIR__ . '/Console/stubs/interface.stub'       => base_path('stubs/interface.stub'),
            
            ], 'stubs');

        }
    }
}
