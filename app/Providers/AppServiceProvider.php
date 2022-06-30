<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    try {
      DB::connection()->getPDO();
    } catch (\Exception $e) {
      abort(500);
    }

    Paginator::useBootstrapFour();

    Blade::directive('money', function ($amount) {
      return "<?php echo 'Rp. ' . number_format($amount, 0); ?>";
});
}
}