<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Produto;

class ProdutoTest extends TestCase
{
    public function test_criacao_de_produto()
    {
        $produto = new Produto([
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto',
            'valor' => 99.90
        ]);

        $this->assertEquals('Produto Teste', $produto->nome);
        $this->assertEquals(99.90, $produto->valor);
    }
}
