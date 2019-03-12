<?php

namespace App\Http\Controllers\Mobiles;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\BannerService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\BrandService;

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

    /**
     * Show products
     */
    public function listProducts(
        Request $request,
        BrandService $brandService,
        CategoryService $categoryService,
        ProductService $productService
    ) {
        $this->validate($request, [
            'brandId'       => 'uuid',
            'categoryId'    => 'uuid',
        ]);
        $brands = $brandService->getBrands();
        $subCategories = $categoryService->getSubCategories();

        $brandId = $request->query->get('brandId');
        if ( ! $brandId && $brands->first()) {
            $brandId = $brands->first()->id;
        }
        $categoryId = $request->query->get('categoryId');
        if ( ! $categoryId && $subCategories->first()) {
            $categoryId = $subCategories->first()->id;
        }
        $products = $productService->getAllProducts($brandId, $categoryId);

        return view('mobile.products', [
            'brandId'       => $brandId,
            'categoryId'    => $categoryId,
            'brands'        => $brands,
            'subCategories' => $subCategories,
            'products'      => $products,
        ]);
    }

    /**
     * Show brands
     */
    public function listBrands(
        Request $request,
        BrandService $brandService
    ) {
        $brands = $brandService->getBrands();

        return view('mobile.brands', [
            'brands'    => $brands,
        ]);
    }
}
