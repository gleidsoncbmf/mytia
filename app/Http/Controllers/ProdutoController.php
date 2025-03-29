<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;


class ProdutoController extends Controller
{
  
    public function index()
    {
        return Produto::all();
    }

    public function store(Request $request)
    {
        $fields =$request->validate([
                'nome' => 'required|max:255',
                'descricao' => 'required|max:255',
                'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'avaliacao' => 'required|max:255',

        ]);

        $produto = Produto::create($fields);

            return [$produto];
        
    }

    public function show(Produto $produto)
    {
        return [$produto];
    }

 
    public function update(Request $request, Produto $produto)
    {
        $fields =$request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:255',
            'valor' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'avaliacao' => 'required|max:255',

    ]);

    $produto->update($fields);

        return [$produto];  

    }


    public function destroy(Produto $produto)
    {
        $produto->delete();

        return [ 'message' => 'Produto Excluído com Sucesso'];
    }
}
