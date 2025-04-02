<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco antes de cada teste

    /** @test */
    public function admin_pode_criar_um_produto()
    {
        // Criar um administrador autenticado
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');

        // Dados do produto
        $produtoData = [
            'nome' => 'Ar-condicionado Split 9000 BTUs',
            'descricao' => 'Um excelente ar-condicionado para ambientes pequenos.',
            'valor' => 2500.00,
            
        ];

        // Enviar requisição para criar produto
        $response = $this->postJson('/api/produtos', $produtoData);


        // Verificar que o produto está no banco de dados
        $this->assertDatabaseHas('produtos', [
            'nome' => 'Ar-condicionado Split 9000 BTUs',
            'valor' => 2500.00
        ]);
    }

    /** @test */
    public function listar_produtos_retorna_os_itens_criados()
    {

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');

        // Criar múltiplos produtos no banco
        Produto::factory()->count(3)->create();
        

        // Fazer requisição para listar produtos
        $response = $this->getJson('/api/produtos');
  

        // Verificar se a resposta contém os produtos criados
        $this->assertCount(3, $response->json());
    }
}
