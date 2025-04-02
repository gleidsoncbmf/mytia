<?php

namespace App\Observers;

use App\Models\Produto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProdutoObserver
{
    /**
     * Quando um produto for criado, limpa o cache.
     */
    public function created(Produto $produto)
    {
        Cache::forget('produtos_lista'); // Limpa o cache da listagem de produtos
        Log::info("Produto criado: {$produto->nome}");
    }

    /**
     * Quando um produto for atualizado, limpa o cache.
     */
    public function updated(Produto $produto)
    {
        Cache::forget('produtos_lista');
        Log::info("Produto atualizado: {$produto->nome}");
    }

    /**
     * Quando um produto for deletado, limpa o cache.
     */
    public function deleted(Produto $produto)
    {
        Cache::forget('produtos_lista');
        Log::warning("Produto excluído: {$produto->nome}");
    }
}
