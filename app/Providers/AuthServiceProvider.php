<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Dividend;
use App\Models\Platform;
use App\Models\Portfolio;
use App\Policies\DividendPolicy;
use App\Policies\PlatformPolicy;
use App\Policies\PortfolioPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Platform::class => PlatformPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Dividend::class => DividendPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::ignoreRoutes();
    }
}
