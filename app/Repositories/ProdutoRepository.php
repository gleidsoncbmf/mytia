<?php

namespace App\Repositories;

use App\Models\Produto;
use App\Repositories\Interfaces\ProdutoRepositoryInterface;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    public function getAll()
    {
        return Produto::all();
    }

    public function findById($id)
    {
        return Produto::find($id);
    }

    public function create(array $data)
    {
        return Produto::create($data);
    }

    public function update($produto, array $data)
    {
        $produto->update($data);
        return $produto;
    }

    public function delete($produto)
    {
        return $produto->delete();
    }
}
