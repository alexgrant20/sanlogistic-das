<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\User;
use App\Policies\AddressPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [];

  /**
   * Register any application authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Gate::before(function ($user, $ability) {
      return $user->hasRole('super-admin') ? true : null;
    });
  }
}