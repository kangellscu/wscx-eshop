<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\CategoryService;
use App\Services\BannerService;
use App\Services\ProductService;
use App\Models\Category as CategoryModel;

class IndexController extends BaseController
{
    /**
     * Show index page
     */
    public function index(
        CategoryService $categoryService,
        BannerService $bannerService,
        ProductService $productService
    ) {
        $banners = $bannerService->getActivedBanners();
        $categories = $categoryService->getCategories();
        return view('web.index', [
            'banners'   => $banners,
            'categories'    => $categories,
            'products'  => $productService->getAllProducts(),
        ]);
    }
}
