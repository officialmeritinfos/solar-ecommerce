<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends BaseController
{
    //landing page
    public function index()
    {
        return view('home.shop.shop')->with([
            'pageName' => "Shop",
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'products' => Product::paginate(30),
        ]);
    }

    //category products
    public function categoryProducts($categorySlug)
    {
        $category = ProductCategory::where('slug', $categorySlug)->firstOrFail();

        $products = Product::where('product_category_id', $category->id)->paginate(30);

        return view('home.shop.category_products')->with([
            'pageName' => $category->name,
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'products' => $products,
        ]);
    }

    //product details
    public function productDetail($slug, $id)
    {
        $product = Product::where([
            'slug' => $slug,
            'id' => $id,
        ])->with([
            'category','specifications','coupons','photos','variants','productCheckoutSpecifications'
        ])->firstOrFail();



        return view('home.shop.product_details')->with([
            'pageName' => $product->name,
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'product' => $product,
        ]);
    }
}
