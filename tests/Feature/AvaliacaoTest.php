<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\Avaliacao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvaliacaoTest extends TestCase
{
    use RefreshDatabase; // Garante que o banco seja resetado a cada teste

    public function test_criacao_de_avaliacao()
{
    // Criação do produto
    $produto = Produto::create([
        'nome' => 'Produto Teste',
        'descricao' => 'Descrição do produto',
        'valor' => 99.90
    ]);
    
    // Criação do usuário autenticado (admin ou moderador)
    $user = User::factory()->create([
        'role' => 'admin'  // Garantir que o usuário tenha a role de admin ou moderador
    ]);

    // Gerar o token do usuário
    $userToken = $user->createToken('Test Token')->plainTextToken;

    // Envia a requisição para criar a avaliação para o produto
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $userToken,
    ])->postJson("/api/produtos/{$produto->id}/avaliacoes", [
        'comentario' => 'Produto excelente!',
    ]);


    // Verificar se a resposta foi OK (201 Created)
    $response->assertStatus(201);


    // Verificar se a avaliação foi salva corretamente
    $this->assertDatabaseHas('avaliacaos', [
        'produto_id' => $produto->id,
        'comentario' => 'Produto excelente!',
    ]);
}

}
