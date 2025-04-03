<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Produto;
use App\Services\AvaliacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    protected $avaliacaoService;

    public function __construct(AvaliacaoService $avaliacaoService)
    {
        $this->avaliacaoService = $avaliacaoService;
    }

    public function store(Request $request, $produtoId)
    {
        $request->validate(['comentario' => 'required|string']);

        $avaliacao = $this->avaliacaoService->storeAvaliacao($produtoId, $request->comentario);

        return response()->json(['message' => 'Avaliação salva com sucesso!', 'avaliacao' => $avaliacao], 201);
    }

    public function index($produtoId)
    {
        $avaliacoes = $this->avaliacaoService->getAvaliacoes($produtoId);

        return response()->json($avaliacoes);
    }

    public function destroy(Produto $produto, Avaliacao $avaliacao)
    {
        if ($avaliacao->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return response()->json(['message' => 'Você não tem permissão para excluir esta avaliação.'], 403);
        }

        $this->avaliacaoService->deleteAvaliacao($avaliacao);

        return response()->json(['message' => 'Avaliação excluída com sucesso.']);
    }
}
