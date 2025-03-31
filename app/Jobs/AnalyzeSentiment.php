<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SentimentAnalysisService;
use App\Models\Avaliacao;
use Illuminate\Support\Facades\Log;

class AnalyzeSentiment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comentario;
    protected $avaliacaoId;

    public function __construct($comentario, $avaliacaoId)
    {
        $this->comentario = $comentario;
        $this->avaliacaoId = $avaliacaoId;
    }

    public function handle(SentimentAnalysisService $service)
    {
        Log::info('Iniciando análise de sentimento para o comentário: ' . $this->comentario);

        try {
            // Chama o método para analisar o sentimento
            $sentimento = $service->analyzeSentiment($this->comentario);

            // Encontra a avaliação
            $avaliacao = Avaliacao::findOrFail($this->avaliacaoId);
            $avaliacao->sentimento = $sentimento;
            $avaliacao->save();

            Log::info('Análise concluída e sentimento salvo: ' . $sentimento);
        } catch (\Exception $e) {
            Log::error('Erro ao analisar o sentimento: ' . $e->getMessage());
        }
    }
}
