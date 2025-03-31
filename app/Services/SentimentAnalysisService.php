<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentAnalysisService
{
    // Método para realizar a análise de sentimento usando a API NLP Cloud
    public function analyzeSentiment($comentario)
    {
        $modelo = 'distilbert-base-uncased-finetuned-sst-2-english'; // Modelo escolhido para análise

        // Realizando a requisição para a API de análise de sentimentos
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . env('NLP_CLOUD_API_KEY'),
            'Content-Type' => 'application/json',
        ])
        ->post("https://api.nlpcloud.io/v1/por_Latn/$modelo/sentiment", [
            'text' => $comentario,
            'target' => 'Produto',  // Se desejar incluir um "target" específico
        ]);

        // Verificando se a resposta foi bem-sucedida
        if ($response->successful()) {
            $sentimento = $response->json();
            Log::info('Resposta da API: ', [$sentimento]);

            // Verificando e retornando o sentimento
            if (isset($sentimento['scored_labels'][0])) {
                return $sentimento['scored_labels'][0]['label']; // Ex: "POSITIVE"
            }

            Log::error('Resposta sem sentimento identificado: ' . json_encode($sentimento));
            return null; // Caso não haja sentimento identificado
        } else {
            Log::error('Erro na resposta da API: ' . $response->body());
            throw new \Exception('Erro ao se comunicar com a API de análise de sentimentos');
        }
    }
}




