<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco antes de cada teste

    public function test_criacao_de_usuario()
    {
       
        $user = new User([
            'name' => 'Usuario de Teste',
            'email' => 'teste@email.com',
            'role' => 'admin',
            'password' => Hash::make('123'), 
            'password_confirmation' => '123'
        ]);

        
        $this->assertEquals('Usuario de Teste', $user->name);
        $this->assertEquals('teste@email.com', $user->email);
        $this->assertEquals('admin', $user->role);
        $this->assertTrue(Hash::check('123', $user->password)); 
    }
}
