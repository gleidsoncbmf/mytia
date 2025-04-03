<?php

namespace App\Repositories\Interfaces;

use App\Models\Avaliacao;

interface AvaliacaoRepositoryInterface
{
    public function store(array $data): Avaliacao;
    public function getByProdutoId(int $produtoId);
    public function delete(Avaliacao $avaliacao);
}
