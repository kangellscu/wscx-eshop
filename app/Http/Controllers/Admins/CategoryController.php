<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    /**
     * List all categories
     */
    public function listAll(
        Request $request,
        CategoryService $categoryService
    ) {
        $this->validate($request, [
            'parentId'  => 'string|uuid',
        ]);

        $categories = $categoryService->listCategories($request->query->get('parentId'));

        return view('admin.categories', [
            'parentId'      => $request->request->get('parentId'),
            'categories'    => $categories,
        ]);
    }

    /**
     * Create new category
     */
    public function createCategory(
        Request $request,
        CategoryService $categoryService
    ) {
        $this->validate($request, [
            'parentId'  => 'uuid',
            'name'      => 'required|string|max:10',
        ]);

        $category = $categoryService->createCategory(
            $request->request->get('name'),
            $request->request->get('parentId')
        );

        return back();
    }

    /**
     * Edit category
     */
    public function editCatetory(
        Request $request,
        CategoryService $categoryService,
        string $id
    ) {
        $request->request->set('categoryId', $id);
        $this->validate($request, [
            'categoryId'    => 'required|uuid',
            'name'          => 'string|max:10',
            'moveDirection' => 'integer',
        ]);

        $categoryService->editCatetory(
            $request->request->get('categoryId'),
            $request->request->get('name'),
            (int) $request->request->get('moveDirection')
        );

        return back();
    }

    /**
     * Delete category
     */
    public function delCatetory(
        Request $request,
        CategoryService $categoryService,
        string $id
    ) {
        $request->request->set('categoryId', $id);
        $this->validate($request, [
            'categoryId'    => 'required|uuid',
        ]);

        $categoryService->delCatetory($request->request->get('categoryId'));

        return redirect()->route('admin.categories');
    }
}
