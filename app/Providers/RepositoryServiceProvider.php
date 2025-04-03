<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\ProdutoRepositoryInterface;
use App\Repositories\ProdutoRepository;
use App\Repositories\Interfaces\AvaliacaoRepositoryInterface;
use App\Repositories\AvaliacaoRepository;
use App\Repositories\Interfaces\InvitationRepositoryInterface;
use App\Repositories\InvitationRepository;
use App\Repositories\Interfaces\PasswordRepositoryInterface;
use App\Repositories\PasswordRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepository::class);
        $this->app->bind(AvaliacaoRepositoryInterface::class, AvaliacaoRepository::class);
        $this->app->bind(InvitationRepositoryInterface::class, InvitationRepository::class);
        $this->app->bind(PasswordRepositoryInterface::class, PasswordRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    public function boot()
    {
        //
    }
}
