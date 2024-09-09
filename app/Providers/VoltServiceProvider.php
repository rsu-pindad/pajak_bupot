<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;
use Illuminate\Support\Number;
use Illuminate\Support\Carbon;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        setlocale(LC_ALL, 'IND');
        config(['app.locale' => 'id']);
        Number::useLocale('id');
        Carbon::setLocale('id');
        Volt::mount([
            config('livewire.view_path', resource_path('views/livewire')),
            resource_path('views/pages'),
        ]);
    }
}
