<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Secao' => 'App\Policies\Secao',
        'App\Estudante' => 'App\Policies\Estudante',
        'App\Emprestimo' => 'App\Policies\Emprestimo',
        'App\Editora' => 'App\Policies\Editora',
        'App\Autor' => 'App\Policies\Autor',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
