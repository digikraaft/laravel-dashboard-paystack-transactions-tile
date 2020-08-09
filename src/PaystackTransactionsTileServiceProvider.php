<?php

namespace Digikraaft\PaystackTransactionsTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PaystackTransactionsTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchTransactionsDataFromPaystackApi::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/paystack-transactions-tile'),
        ], 'paystack-transactions-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-paystack-transactions-tile');

        Livewire::component('paystack-transactions-tile', PaystackTransactionsTileComponent::class);
    }
}
