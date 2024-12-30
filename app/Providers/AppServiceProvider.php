<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Grant::class => GrantPolicy::class,
        Academician::class => AcademicianPolicy::class,
        Milestone::class => MilestonePolicy::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Gate::define('admin', function ($user) {
            return $user->role === 'admin_executive';
        });

        Gate::define('members', function ($user) {
            return $user->role === 'project_member';
        });

        Gate::define('all', function ($user) {
            return in_array($user->role, ['project_member', 'admin_executive']);
        });
    }
}
