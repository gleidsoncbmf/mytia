<?php

namespace App\Jobs;

use App\Models\Avaliacao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessarSentimentoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $avaliacao;

    public function __construct(Avaliacao $avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }

    public function handle()
    {
        // Chave de API da MeaningCloud (troque pela sua)
        $apiKey = env('MEANINGCLOUD_API_KEY');

        $response = Http::post('https://api.meaningcloud.com/sentiment-2.1', [
            'key' => $apiKey,
            'lang' => 'pt', // Define o idioma como português
            'txt' => $this->avaliacao->comentario,
        ]);

        // Verifica se a API respondeu corretamente
        if ($response->successful()) {
            $sentimento = $response->json()['score_tag'] ?? 'NEUTRAL';

            // Atualiza a avaliação com o sentimento detectado
            $this->avaliacao->update(['sentimento' => $sentimento]);
        }
    }
}
