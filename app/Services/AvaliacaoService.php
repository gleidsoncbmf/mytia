<?php

namespace App\Services;

use App\Jobs\AnalyzeSentiment;
use App\Repositories\Interfaces\AvaliacaoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AvaliacaoService
{
    protected $avaliacaoRepository;

    public function __construct(AvaliacaoRepositoryInterface $avaliacaoRepository)
    {
        $this->avaliacaoRepository = $avaliacaoRepository;
    }

    public function storeAvaliacao($produtoId, $comentario)
    {
        $avaliacao = $this->avaliacaoRepository->store([
            'comentario' => $comentario,
            'produto_id' => $produtoId,
            'user_id' => Auth::id(),
            'sentimento' => 'pending',
        ]);

        AnalyzeSentiment::dispatch($comentario, $avaliacao->id);
        Cache::forget("produto_{$produtoId}_avaliacoes");

        return $avaliacao;
    }

    public function getAvaliacoes($produtoId)
    {
        return $this->avaliacaoRepository->getByProdutoId($produtoId);
    }

    public function deleteAvaliacao($avaliacao)
    {
        return $this->avaliacaoRepository->delete($avaliacao);
    }
}
