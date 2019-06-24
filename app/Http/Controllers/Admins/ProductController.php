<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Exceptions\Products\ProductCategoryCantDeleteException;
use App\Exceptions\Products\ProductBrandNotExistsException;

class ProductController extends BaseController
{
    /**
     * List all brands
     */
    public function listAll(
        Request $request,
        ProductService $productService,
        BrandService $brandService,
        CategoryService $categoryService
    ) {
        $this->validate($request, [
            'categoryId'    => 'nullable|uuid',
            'brandId'       => 'nullable|uuid',
            'page'          => 'integer|min:1|max:1000',
            'size'          => 'integer|min:1|max:100',
        ]);
        $page = (int) $request->query->get('page', 1);
        $res = $productService->listProducts(
            $request->request->get('categoryId'),
            $request->request->get('brandId'),
            $page,
            $request->request->get('size', $this->defaultPageSize)
        );

        return view('admin.products', [
            'brands'        => $brandService->getBrands(),
            'categories'    => $categoryService->getCategories(),
            'brandId'       => $request->request->get('brandId'),
            'categoryId'    => $request->request->get('categoryId'),
            'products'      => $res->products,
            'page'          => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'    => $res->totalPages,
        ]);
    }

    /**
     * Show product form page
     */
    public function showForm(
        Request $request,
        ProductService $productService,
        BrandService $brandService,
        CategoryService $categoryService
    ) {
        $this->validate($request, [
            'productId' => 'uuid',
        ]);

        $product = null;
        if ($productId = $request->query->get('productId')) {
            $product = $productService->getProduct($productId);
        }

        return view('admin.productForm', [
            'product'       => $product,
            'brands'        => $brandService->getBrands(),
            'categories'    => $categoryService->getCategories(),
            'productStatusMap'  => $productService->getStatusMap(),
        ]);
    }

    /**
     * Create product
     */
    public function createProduct(
        Request $request,
        ProductService $productService,
        BrandService $brandService,
        CategoryService $categoryService
    ) {
        $this->validate($request, [
            'name'          => 'required|string|max:128',
            'brandId'       => 'required|uuid',
            'categoryId'    => 'required|uuid',
            'briefDesc'     => 'required|string:512',
            'status'        => 'required|integer|in:1,-1',
            'thumbnail'     => 'required|image|max:2000|mimes:jpeg,png,jpg,svg|dimensions:width=102,height=93',
            'url'           => 'string|nullable|max:256',
            'docSpecification'  => 'file|max:10000|mimes:pdf',
            'doc'               => 'file|max:10000|mimes:pdf',
            'docInstruction'    => 'file|max:10000|mimes:pdf',
            'docOther'          => 'file|max:10000|mimes:pdf',
        ], [
            'thumbnail.dimensions'  => '图片规格为: 102 * 93',
        ]);

        $this->checkBrand($request->request->get('brandId'), $brandService);
        $this->checkCategory($request->request->get('categoryId'), $categoryService);

        $product = $productService->createProduct(
            $request->request->get('name'),
            $request->request->get('brandId'),
            $request->request->get('categoryId'),
            $request->request->get('briefDesc'),
            $request->request->get('status'),
            $request->request->get('url') ?: null,
            $request->file('thumbnail'),
            $request->file('docSpecification'),
            $request->file('doc'),
            $request->file('docInstruction'),
            $request->file('docOther')
        );

        return redirect()->route('admin.products');
    }

    /**
     * Edit product
     */
    public function editProduct(
        Request $request,
        ProductService $productService,
        BrandService $brandService,
        CategoryService $categoryService,
        string $id
    ) {
        $request->request->set('productId', $id);
        $this->validate($request, [
            'productId'     => 'required|uuid',
            'brandId'       => 'required|uuid',
            'categoryId'    => 'required|uuid',
            'briefDesc'     => 'required|string:512',
            'status'        => 'required|integer|in:1,-1',
            'url'           => 'string|nullable|max:256',
            'thumbnail'     => 'image|max:2000|mimes:jpeg,png,jpg,svg|dimensions:width=102,height=93',
            'docSpecification'  => 'file|max:10000|mimes:pdf',
            'doc'           => 'file|max:10000|mimes:pdf',
            'docInstruction'    => 'file|max:10000|mimes:pdf',
            'docOther'      => 'file|max:10000|mimes:pdf',
        ], [
            'thumbnail.dimensions'  => '图片规格为: 102 * 93',
        ]);

        $this->checkBrand($request->request->get('brandId'), $brandService);
        $this->checkCategory($request->request->get('categoryId'), $categoryService);

        $productService->editProduct(
            $request->request->get('productId'),
            $request->request->get('name'),
            $request->request->get('brandId'),
            $request->request->get('categoryId'),
            $request->request->get('briefDesc'),
            (int) $request->request->get('status'), 
            $request->request->get('url') ?: null,
            $request->file('thumbnail'),
            $request->file('docSpecification'),
            $request->file('doc'),
            $request->file('docInstruction'),
            $request->file('docOther')
        );

        return redirect()->route('admin.products');
    }

    /**
     * Delete product
     */
    public function delProduct(
        Request $request,
        ProductService $productService,
        string $id
    ) {
        $request->request->set('productId', $id);
        $this->validate($request, [
            'productId'  => 'required|uuid',
        ]);

        $productService->delProduct($request->request->get('productId'));

        return redirect()->route('admin.products');
    }

    protected function checkBrand(string $brandId, BrandService $brandService) {
        if ( ! $brandService->getBrand($brandId)) {
            throw new ProductBrandNotExistsException('品牌不存在');
        }
    }

    protected function checkCategory(string $categoryId, CategoryService $categoryService) {
        if ( ! $categoryService->getCategory($categoryId)) {
            throw new ProductCategoryNotExistsException('类别不存在');
        }
    }
}
