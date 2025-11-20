<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\Facades\Gate;
use App\Models\Propiedad;
use App\Models\Inquilino;
use App\Models\Pago;
use App\Models\Deposito;
use App\Policies\PropiedadPolicy;
use App\Policies\InquilinoPolicy;
use App\Policies\PagoPolicy;
use App\Policies\DepositoPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Propiedad::class => PropiedadPolicy::class,
        Inquilino::class => InquilinoPolicy::class,
        Pago::class => PagoPolicy::class,
        Deposito::class => DepositoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}