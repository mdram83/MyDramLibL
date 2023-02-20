<?php

namespace App\Providers;

use App\Utilities\Librarian\NavigatorInterface;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(NavigatorInterface $navigator)
    {
        view()->share('navigator', $navigator);
    }
}
