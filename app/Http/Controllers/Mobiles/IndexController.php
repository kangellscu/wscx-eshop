<?php

namespace App\Http\Controllers\Mobiles;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\BannerService;
use App\Services\CategoryService;
use App\Services\ProductService;

class IndexController extends BaseController
{
    /**
     * Show index page
     */
    public function index(
        Request $request,
        BannerService $bannerService,
        CategoryService $categoryService,
        ProductService $productService
    ) {
        return view('mobile.index', [
            'banners'       => $bannerService->getActivedBanners(),
            'topCategories' => $categoryService->getTopCategories(),
            'products'      => $productService->getAllProducts(),
        ]);
    }
}
