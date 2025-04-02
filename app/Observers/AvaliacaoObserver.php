<?php

namespace App\Observers;

use App\Models\Avaliacao;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AvaliacaoObserver
{
    /**
     * Quando uma avaliação for criada, limpa o cache e registra no log.
     */
    public function created(Avaliacao $avaliacao)
    {
        Cache::forget("avaliacoes_produto_{$avaliacao->produto_id}");
        Log::info("Nova avaliação adicionada para o produto ID: {$avaliacao->produto_id} por {$avaliacao->user->name}");
    }

    /**
     * Quando uma avaliação for atualizada, limpa o cache e registra no log.
     */
    public function updated(Avaliacao $avaliacao)
    {
        Cache::forget("avaliacoes_produto_{$avaliacao->produto_id}");
        Log::info("Avaliação ID {$avaliacao->id} foi atualizada para o produto ID: {$avaliacao->produto_id}");
    }

    /**
     * Quando uma avaliação for deletada, limpa o cache e registra no log.
     */
    public function deleted(Avaliacao $avaliacao)
    {
        Cache::forget("avaliacoes_produto_{$avaliacao->produto_id}");
        Log::warning("Avaliação ID {$avaliacao->id} foi excluída do produto ID: {$avaliacao->produto_id}");
    }
}
