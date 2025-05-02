<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Action' => 'App\Policies\Admin\ActionPolicy',
        'App\Models\Role' => 'App\Policies\Admin\RolePolicy',
    ];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
            Passport::tokensExpireIn(now()->addDays(env('OUATH_TOKEN_EXPIRE_DAYS')));
            Passport::refreshTokensExpireIn(now()->addDays(env('REFRESH_TOKEN_EXPIRE_DAYS')));
        }
    }
}
