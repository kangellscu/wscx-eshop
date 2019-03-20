<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\CategoryService;
use App\Services\BannerService;
use App\Models\Category as CategoryModel;

class IndexController extends BaseController
{
    /**
     * Show index page
     */
    public function index(
        CategoryService $categoryService,
        BannerService $bannerService
    ) {
        $maxDisplayNum = 12;
        $banners = $bannerService->getActivedBanners();
        $categories = $categoryService->getCategories();
        $categoryProducts = $categoryService->getCategoryProducts(
            CategoryModel::SUB_CATEGORY_LEVEL, $maxDisplayNum
        );
        return view('web.index', [
            'banners'   => $banners,
            'categories'    => $categories,
            'categoryProducts'  => $categoryProducts,
            'maxDisplayNum' => $maxDisplayNum,
        ]);
    }
}
