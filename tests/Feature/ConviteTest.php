<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteMail;

class ConviteTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco antes de cada teste

    /** @test */
    public function admin_pode_gerar_convite_e_usuario_pode_se_cadastrar_com_o_token()
    {
        Mail::fake(); // Impede envio real de e-mails

        // Criar e autenticar um administrador
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin, 'sanctum');

        // 1️⃣ Enviar requisição para gerar convite
        $emailConvidado = 'convidado@example.com';

        $response = $this->postJson('/api/gerar-convite', [
            'email' => $emailConvidado
        ]);

        // Verificar que o convite foi gerado com sucesso
        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'token']);


        // Capturar o token gerado
        $token = $response->json('token');
  
        // Garantir que o token está salvo no banco
        $this->assertDatabaseHas('invitations', [
            'email' => $emailConvidado,
            'token' => $token,
        ]);

        Mail::assertSent(InviteMail::class, function ($mail) use ($emailConvidado, $token) {
            return $mail->hasTo($emailConvidado) && str_contains($mail->render(), $token);
        });

        // 2️⃣ Tentar cadastrar um usuário com o token recebido
        $responseCadastro = $this->postJson('/api/cadastro-de-convidado', [
            'name' => 'Novo Usuário',
            'email' => $emailConvidado,
            'password' => 'senhaSegura123',
            'password_confirmation' => 'senhaSegura123',
            'token' => $token
        ]);

        // Verificar se o cadastro foi bem-sucedido
        $responseCadastro->assertStatus(200)
            ->assertJson(['message' => 'Usuário registrado com sucesso!']);

          // Garantir que o usuário foi criado no banco
          $this->assertDatabaseHas('users', [
            'email' => $emailConvidado
        ]);
    }
        
    
}
