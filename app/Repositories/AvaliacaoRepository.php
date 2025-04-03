<?php

namespace App\Repositories;

use App\Models\Avaliacao;
use App\Repositories\Interfaces\AvaliacaoRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class AvaliacaoRepository implements AvaliacaoRepositoryInterface
{
    public function store(array $data): Avaliacao
    {
        return Avaliacao::create($data);
    }

    public function getByProdutoId(int $produtoId)
    {
        return Cache::remember("produto_{$produtoId}_avaliacoes", 60, function () use ($produtoId) {
            return Avaliacao::where('produto_id', $produtoId)->get();
        });
    }

    public function delete(Avaliacao $avaliacao)
    {
        return $avaliacao->delete();
    }
}
