<?php

namespace App\Repositories\Interfaces;

interface ProdutoRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($produto, array $data);
    public function delete($produto);
}
