<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Brand;
use App\Helpers\CartHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller {

    public function homePage(Request $request) {
        // return session()->get('cart_session_id');
        $categories = Category::all();
        $genders = Gender::all();
        // Get top picks products (featured or latest active products)
        $topPicksProducts = Product::where('is_active', 1)
            ->with(['brand', 'variants.values.attribute', 'bundleItems.child.variants.values.attribute'])
            ->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->take(8)->get();
        return view('website.pages.home.index', compact('categories', 'genders', 'topPicksProducts' ));
    }

    public function aboutPage(Request $request) {
        return view('website.pages.about.index');
    }

    public function contactPage(Request $request) {
        return view('website.pages.contact.index');
    }

    public function shopAll(Request $request) {
        // Start building the query
        $query = Product::where('is_active', 1)->with(['brand', 'variants.values.attribute', 'bundleItems.child.variants.values.attribute']);
        // Filter by categories
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        // Filter by brands
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }
        // Get filtered products
        $products = $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        // Get all categories with their children
        $allCategories = Category::where('parent_id', null)->with('children')->get();
        // Get all brands
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('website.pages.shopAll.index', compact('products', 'allCategories', 'brands'));
    }

     public function shopByGender(Request $request, $slug) {
        $gender = Gender::where('slug', $slug)->firstOrFail();
         // Start building the query
        $query = Product::where('is_active', 1)->whereHas('categories', function($query) use ($gender) {
                $query->where('gender_id', $gender->id);
        })->with(['brand', 'variants.values.attribute', 'bundleItems.child.variants.values.attribute']);
        // Filter by categories
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        // Filter by brands
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }
        $allCategories = Category::where('parent_id', null)->get();
        // Get filtered products
        $products = $query->orderBy('is_featured', 'desc')->paginate(20)->appends($request->query());
        // Get all brands
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('website.pages.shopGender.index', compact('gender', 'products', 'allCategories', 'brands'));
    }

    public function shopByBrand(Request $request, $slug) {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $allCategories = Category::where('parent_id', null)->get();
        // Get products for this brand with optional category filter
        $query = Product::where('is_active', 1)->where('brand_id', $brand->id)->with(['brand', 'variants.values.attribute', 'bundleItems.child.variants.values.attribute']);
        // Filter by categories if provided
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        // Get filtered products
        $products = $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('website.pages.shopBrand.index', compact('brand', 'allCategories', 'products', 'brands'));
    }

    public function shopByCategory(Request $request, $slug) {
        $category = Category::where('slug', $slug)->first();
         // Start building the query
        $query = Product::where('is_active', 1)->whereHas('categories', function($q) use ($category) {
            $q->where('categories.id', $category->id);
        })->with(['brand', 'variants.values.attribute', 'bundleItems.child.variants.values.attribute']);
        // Filter by categories
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        // Filter by brands
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }
        $allCategories = Category::where('parent_id', null)->with('children')->get();
        // Get filtered products
        $products = $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());
        // Get all categories with their children
        $allSubCategories = Category::where('parent_id', $category->id)->with('children')->get();
        // Get all brands
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('website.pages.shopCategory.index', compact('category', 'products', 'allCategories', 'allSubCategories', 'brands'));
    }



}
