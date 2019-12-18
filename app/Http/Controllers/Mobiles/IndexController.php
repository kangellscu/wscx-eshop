<?php

namespace App\Http\Controllers\Mobiles;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\BannerService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\UserCommentService;

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
            'from'          => 'required|string|in:category,brand',
            'brandId'       => 'uuid|required_if:from,brand',
            'categoryId'    => 'uuid|required_if:from,category',
        ]);
        $brands = $brandService->getBrands();
        $subCategories = $categoryService->getSubCategories();
        $brandId = $request->query->get('brandId');
        $categoryId = $request->query->get('categoryId');
        $from = $request->query->get('from');
        if ($from == 'category') {
            if ($subCategories->where('id', $categoryId)->count()) {
                // sub category
                $topCategoryId = $subCategories->where('id', $categoryId)->first()->parentId;    

            } else {
                // top category
                $topCategoryId = $categoryId;
            }
            $ids = $subCategories->where('parentId', $topCategoryId)->pluck('id')->toArray();
            $distinctCategoryIds = $subCategories->where('parentId', $topCategoryId)
                ->map(function ($category) {
                    return (object) [
                        'id'    => $category->id,
                    ];
                });
            $distinctBrandIds = $productService->getProductsDistinctBrandIds($ids);
            $brandId = $brandId ?: $distinctBrandIds->first()->id;
            if ($topCategoryId == $categoryId) {
                $categoryId = $distinctCategoryIds->first()->id;
            }
        } else {
            $distinctCategoryIds = $productService->getProductsDistinctCategoryIds($brandId);
            $distinctBrandIds = collect([
                (object) [
                    'id'    => $brandId,
                ]]);
            $categoryId = $categoryId ?: $distinctCategoryIds->first()->id;
        }

        $products = $productService->getAllProducts($brandId, $categoryId);

        return view('mobile.products', [
            'from'          => $from,
            'brandId'       => $brandId,
            'categoryId'    => $categoryId,
            'brands'        => $brands,
            'subCategories' => $subCategories,
            'distinctCategoryIds'   => $distinctCategoryIds,
            'distinctBrandIds'  => $distinctBrandIds,
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

    /**
     * show comment form
     */
    public function showCommentForm(
        Request $request
    ) {
        return view('mobile.comments');
    }

    /**
     *
     */
    public function addComment(
        Request $request,
        UserCommentService $userCommentService
    ) {
        $this->validate($request, [
            'name'  => 'required|string|max:16',
            'comment'   => 'required|string|max:256',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|phone',
        ]);

        $commentId = $userCommentService->addComment(
            $request->request->get('name'),
            $request->request->get('email'),
            $request->request->get('phone'),
            $request->request->get('comment')
        );

        return back()->with('submitStatus', 'success');
    }
}