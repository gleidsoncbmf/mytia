<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeSentiment;
use App\Models\Avaliacao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    /**
     * Armazena uma nova avaliação e dispara o job de análise de sentimento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $produtoId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $produtoId)
    {
        // Validação da requisição
        $request->validate([
            'comentario' => 'required|string',
        ]);

        // Criação da avaliação
        $avaliacao = Avaliacao::create([
            'comentario' => $request->comentario,
            'produto_id' => $produtoId,
            'user_id' => Auth::id(),
            'sentimento' => 'pending', // Sentimento inicial como pendente
        ]);

        // Despacha o job para análise de sentimento
        AnalyzeSentiment::dispatch($request->comentario, $avaliacao->id);

        return response()->json(['message' => 'Avaliação salva com sucesso!']);
    }
    public function index($produtoId)
    {
        // Obtendo todas as avaliações do produto
        $avaliacoes = Avaliacao::where('produto_id', $produtoId)->get();

        return response()->json($avaliacoes);
    }

    public function destroy(Produto $produto, Avaliacao $avaliacao)
{
    // Verifica se o usuário autenticado é o dono da avaliação ou um administrador
    if ($avaliacao->user_id !== auth()->id() && !auth()->user()->is_admin) {
        return response()->json(['message' => 'Você não tem permissão para excluir esta avaliação.'], 403);
    }

    // Deleta a avaliação
    $avaliacao->delete();

    return response()->json(['message' => 'Avaliação excluída com sucesso.']);
}
}
