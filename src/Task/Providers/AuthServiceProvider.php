<?php

namespace Freelance\Task\Providers;

use Freelance\User\Contracts\AuthorizationService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            $moduleName = explode('\\', explode('Freelance\\', $modelClass)[1])[0];
            return 'Freelance\\' .
                   $moduleName .
                   '\Application\Policies\\' .
                   (class_basename($modelClass)) .
                   'Policy';
        });

        Gate::after(function ($user, $ability) {
            return $user->hasRole(app(AuthorizationService::class)->adminRole()); // note this returns boolean
        });
    }
}
