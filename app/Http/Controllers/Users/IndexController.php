<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\CategoryService;
use App\Services\BannerService;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\UserCommentService;
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

    /**
     * Show products
     */
    public function listProducts(
        Request $request,
        BrandService $brandService,
        CategoryService $categoryService,
        ProductService $productService
    ) {
        // todo
    }

    /**
     * Show brands
     */
    public function listBrands(
        Request $request,
        BrandService $brandService
    ) {
        $brands = $brandService->getBrands();

        return view('web.brands', [
            'brands'    => $brands,
        ]);
    }

    /**
     * Show comment form
     */
    public function showCommentForm(
        Request $request
    ) {
        return view('web.comments');
    }

    /**
     * Submit comment
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
