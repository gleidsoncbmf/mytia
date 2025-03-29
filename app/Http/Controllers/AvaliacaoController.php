<?php


namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    // Listar avaliações por produto
    public function index(Produto $produto)
    {
        return response()->json($produto->avaliacoes()->with('user')->get());
    }

    // Criar uma nova avaliação (somente usuários autenticados)
    public function store(Request $request, Produto $produto)
    {
        $fields = $request->validate([

            'comentario' => 'required|string|max:1000'
        ]);

        $avaliacao = Avaliacao::create([
            'user_id' => Auth::id(),
            'produto_id' => $produto->id,
            'comentario' => $fields['comentario'],
        ]);

        // Dispara um Job para processar análise de sentimento (iremos criar esse Job depois)
        dispatch(new \App\Jobs\ProcessarSentimentoJob($avaliacao));

        return response()->json($avaliacao, 201);
    }

    // Excluir avaliação (somente admin ou o próprio usuário)
    public function destroy(Avaliacao $avaliacao)
    {
        if (Auth::id() !== $avaliacao->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $avaliacao->delete();
        return response()->json(['message' => 'Avaliação excluída com sucesso']);
    }
}

