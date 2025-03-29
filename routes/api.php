<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;


//Rotas do Administrador
Route::middleware(['auth:sanctum', AdminMiddleware::class])->post('/produtos', [ProdutoController::class, 'store']);
Route::middleware('auth:sanctum', AdminMiddleware::class)->post('/gerar-convite', [InviteController::class, 'generateInvite']);

//Rotas para usuários autenticados
Route::get('/produtos', [ProdutoController::class,'index']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Rotas para todos, inclusive não autenticados
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rota para o convidado se cadastrar
Route::post('/cadastro-de-convidado', [AuthController::class, 'registerWithInvite']);


