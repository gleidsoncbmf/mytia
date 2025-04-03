<?php

namespace App\Services;

use App\Repositories\Interfaces\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProdutoService
{
    protected $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function getAllProdutos()
    {
        return Cache::remember('produtos_lista', 60, function () {
            return $this->produtoRepository->getAll();
        });
    }

    public function createProduto(array $data)
    {
        $produto = $this->produtoRepository->create($data);
        Cache::forget('produtos_lista');
        return $produto;
    }

    public function updateProduto($id, array $data)
    {
        $produto = $this->produtoRepository->findById($id);
        if (!$produto) {
            return null;
        }

        return $this->produtoRepository->update($produto, $data);
    }

    public function deleteProduto($id)
    {
        $produto = $this->produtoRepository->findById($id);
        if (!$produto) {
            return false;
        }

        return $this->produtoRepository->delete($produto);
    }
    public function getProdutoById($id)
    {
        return $this->produtoRepository->findById($id);
    }
}
