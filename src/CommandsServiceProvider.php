<?php

namespace Helixar\Laraconsole;

use Helixar\Laraconsole\Commands\Fill;
use Illuminate\Support\ServiceProvider;
use Helixar\Laraconsole\Commands\All;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands([
            All::class,
            Fill::class
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
