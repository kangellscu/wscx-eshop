<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\BrandService;

class BrandController extends BaseController
{
    /**
     * List all brands
     */
    public function listAll(
        Request $request,
        BrandService $brandService
    ) {
        $this->validate($request, [
            'page'  => 'integer|min:1|max:1000',
            'size'  => 'integer|min:1|max:100',
        ]);
        $page = (int) $request->query->get('page', 1);
        $res = $brandService->listBrands(
            $page,
            (int) $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.brands', [
            'brands'        => $res->brands,
            'page'          => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'    => $res->totalPages,
        ]);
    }

    /**
     * Display brand form
     */
    public function showBrandForm(
        Request $request,
        BrandService $brandService
    ) {
        $this->validate($request, [
            'brandId'   => 'uuid',
        ]);

        $brand = null;
        if ($brandId = $request->query->get('brandId')) {
            $brand = $brandService->getBrand($brandId);
        }

        return view('admin.brandForm', [
            'brand' => $brand,
        ]);
    }

    /**
     * Create brand
     */
    public function createBrand(
        Request $request,
        BrandService $brandService
    ) {
        $this->validate($request, [
            'nameCapital'   => 'required|alpha',
            'name'          => 'required|string|max:32',
            'logo'          => 'required|max:100|mimes:jpeg,png,jpg',
            'story'         => 'string|nullable|max:512',
        ]);

        $brandService->createBrand(
            $request->request->get('nameCapital'),
            $request->request->get('name'),
            (string) $request->request->get('story', ''),
            $request->file('logo')
        );

        return back();
    }

    /**
     * Edit brand
     */
    public function editBrand(
        Request $request,
        BrandService $brandService,
        string $id
    ) {
        $request->request->set('brandId', $id);
        $this->validate($request, [
            'brandId'       => 'required|uuid',
            'nameCapital'   => 'required|alpha',
            'name'          => 'required|string|max:32',
            'logo'          => 'max:100|mimes:jpeg,png,jpg',
            'story'         => 'string|nullable|max:512',
        ]);

        $brandService->editBrand(
            $request->request->get('brandId'),
            $request->request->get('nameCapital'),
            $request->request->get('name'),
            (string) $request->request->get('story', ''),
            $request->file('logo')
        );

        return back();
    }

    /**
     * Delete brand
     */
    public function delBrand(
        Request $request,
        BrandService $brandService,
        string $id
    ) {
        $request->request->set('brandId', $id);
        $this->validate($request, [
            'brandId'       => 'required|uuid',
        ]);

        $brandService->delBrand($request->request->get('brandId'));

        return back();
    }
}
