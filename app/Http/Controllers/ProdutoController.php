<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ProdutoController extends Controller
{
  
    public function index()
    {
        // Tenta obter os produtos do cache
        $produtos = Cache::remember('produtos_lista', 60, function () {
            return Produto::all();
        });

    return response()->json($produtos);

        return Produto::all();
    }

    public function store(Request $request)
    {
        $fields =$request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'required|max:255',
                'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                

        ]);

        $produto = Produto::create($fields);

        // Limpa o cache de produtos
        Cache::forget('produtos_lista');

            return [$produto];
   
        
    }

    public function show(Produto $produto)
    {
        return [$produto];
    }

 

    public function update(Request $request, $id)
{
    // Buscar o produto pelo ID
    $produto = Produto::find($id);

    // Se não encontrar, retorna erro
    if (!$produto) {
        return response()->json(['message' => 'Produto não encontrado.'], 404);
    }

    // Validação dos campos
        $fields =$request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:255',
            'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            

    ]);

    // Atualizar os campos do produto
    $produto->update($fields);

    return response()->json([
        'message' => 'Produto atualizado com sucesso!',
        'produto' => $produto
    ]);

    }


    public function destroy($id)
    {
        // Busca o produto pelo ID
        $produto = Produto::find($id);
    
        // Verifica se o produto existe
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }
    
        // Deleta o produto
        $produto->delete();
    
        return response()->json(['message' => 'Produto excluído com sucesso'], 200);
    }
    
}
