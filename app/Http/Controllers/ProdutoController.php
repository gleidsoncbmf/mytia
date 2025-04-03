<?php

namespace App\Http\Controllers;

use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function index()
    {
        $produtos = $this->produtoService->getAllProdutos();
        return response()->json($produtos);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:255',
            'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $produto = $this->produtoService->createProduto($fields);
        return response()->json($produto, 201);
    }

    public function show($id)
    {
        $produto = $this->produtoService->getProdutoById($id);
    
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }
    
        return response()->json($produto);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:255',
            'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $produto = $this->produtoService->updateProduto($id, $fields);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        return response()->json(['message' => 'Produto atualizado com sucesso!', 'produto' => $produto]);
    }

    public function destroy($id)
    {
        $deletado = $this->produtoService->deleteProduto($id);
        if (!$deletado) {
            return response()->json(['message' => 'Produto não encontrado.'], 404);
        }

        return response()->json(['message' => 'Produto excluído com sucesso.']);
    }
}
