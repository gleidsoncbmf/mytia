<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\AvaliacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminOrModeratorMiddleware;


// Rotas do Administrador
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::put('/editar-user/{id}', [UserController::class, 'update']);
    Route::post('/gerar-convite', [InviteController::class, 'generateInvite']);

});

// Rotas do Administrador e Moderador
Route::middleware(['auth:sanctum', AdminOrModeratorMiddleware::class])->group(function () {
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::put('/produtos/editar/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produtos/delete/{id}', [ProdutoController::class, 'destroy']);
});

// Rotas para usuários autenticados
Route::middleware('auth:sanctum')->group(function () {  
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/produtos/{produto}/avaliacoes', [AvaliacaoController::class, 'store']);
    Route::delete('/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy']);
});

//Rotas para todos, inclusive não autenticados
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']); 
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']); 
Route::get('/produtos', [ProdutoController::class,'index']);
Route::get('/produtos/{produto}/avaliacoes', [AvaliacaoController::class, 'index']);

//Rota para criar uma nova senha
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset'); 

//Rota para o convidado se cadastrar
Route::post('/cadastro-de-convidado', [AuthController::class, 'registerWithInvite']); 





