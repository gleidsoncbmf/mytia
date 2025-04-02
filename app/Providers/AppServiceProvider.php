<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Produto;
use App\Observers\ProdutoObserver;
use App\Models\Avaliacao;
use App\Observers\AvaliacaoObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Produto::observe(ProdutoObserver::class);
        Avaliacao::observe(AvaliacaoObserver::class);
        Schema::defaultStringLength(191);
    }
}
