<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Gender;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\CartHelper;
use App\Models\Setting;

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
     */
    public function boot(): void
    {
        // Set default pagination view
        Paginator::defaultView('pagination::default');

        // Share navigation data with navbar and mobile menu
        View::composer(['website.main.navbar', 'website.pages.home.mobileMenu'], function ($view) {
            $navGenders       = Gender::with(['categories' => function($query) {
                $query->whereNull('parent_id')->with('children');
            }])->get();
            $navBrands        = Brand::orderBy('name', 'asc')->get();
            $navCategories    = Category::whereNull('parent_id')->with('children')->orderBy('name', 'asc')->get();
            $topPicksProducts = Product::where('is_active', 1)->with(['brand', 'variants.values.attribute'])->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->take(8)->get();
            $view->with([
                'navGenders' => $navGenders,
                'navBrands' => $navBrands,
                'navCategories' => $navCategories,
                'topPicksProducts' => $topPicksProducts
            ]);
        });

        // Share cart and settings data with website views only (not admin)
        View::composer('website.*', function ($view) {
            $cart = CartHelper::getCurrentCart();
            $settings = Setting::all()->pluck('value', 'key'); // Convert to key-value pairs for easy access
            $view->with([
                'cart' => $cart,
                'settings' => $settings
            ]);
        });
    }
}
