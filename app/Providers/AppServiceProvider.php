<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Yayasan;
use App\Models\UnitPendidikan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
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
        $yayasan = Yayasan::where('id', 1)->first();
        View::share('yayasan', $yayasan);  // Share the company data globally

         // Ambil semua unit pendidikan
        $units = UnitPendidikan::with('navbars')->get();

        // Share ke semua view
        View::share('units', $units);
    }
}
