<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Category as CategoryModel;
use App\Exceptions\Products\ProductCategoryCantDeleteException;
use App\Exceptions\Products\ProductCategoryNotExistsException;

class CategoryService
{
    /**
     * List all categories
     *
     * @return Collection       elements as below:
     *                          - id string
     *                          - name string
     *                          - subs Collection
     *                              - id string
     *                              - name
     */
    public function listCategories() : Collection {
        $topCategories = CategoryModel::whereNull('parent_id')
            ->orderBy('display_order')
            ->get();
        $topCategoryIds = $topCategories->pluck('id')->all();
        $subCategories = CategoryModel::whereIn('parent_id', $topCategoryIds)->get();

        return $topCategories->map(function ($topCategory) use ($subCategories) {
                $subs = $subCategories->where('parent_id', $topCategory->id)
                    ->sortBy('display_order')
                    ->map(function ($subCategory) {
                            return (object) [
                                'id'    => $subCategory->id,
                                'name'  => $subCategory->name,
                            ];
                        });

                return (object) [
                    'id'    => $topCategory->id,
                    'name'  => $topCategory->name,
                    'subs'  => $subs,
                ];
            });
    }

    /**
     * Create new category
     *
     * @param string $name
     * @param ?string $parentId
     *
     * @return void
     */
    public function createCategory(string $name, ?string $parentId) {
        if ($parentId) {
            $parentCategory = CategoryModel::find($parentId);
            if ( ! $parentCategory) {
                throw new ProductCategoryNotExistsException('该子类别没有所属的父类别');
            }
        }

        $maxDisplayOrder = CategoryModel::max('display_order') ?: 0;

        CategoryModel::create([
            'name'          => $name,
            'parent_id'     => $parentId,
            'display_order' => $maxDisplayOrder,
        ]);
    }


    /**
     * Edit category
     *
     * @param string $categoryId
     * @param ?string $name
     * @param ?integer $moveDirection   正数表示后移一位，负数表示前移一位
     *
     * @return integer affected rows
     */
    public function editCatetory(
        string $categoryId,
        ?string $name,
        ?int $moveDirection
    ) : int {
        $category = CategoryModel::find($categoryId);
        if ( ! $category) {
            return 0;
        }

        if ($name) {
            $category->name = $name;
        }

        // 前移 or 后移
        if ( ! is_null($moveDirection) && $moveDirection != 0) {
            $tmpDisplayOrder = $category->display_order;
            if ($moveDirection > 0) {
                $exchangeCategory = CategoryModel::where('display_order', '>', $tmpDisplayOrder)
                    ->orderBy('display_order')
                    ->first();
            } else {
                $exchangeCategory = CategoryModel::where('display_order', '<', $tmpDisplayOrder)
                    ->orderBy('display_order', 'desc')
                    ->first();
            }

            if ($exchangeCategory) {
                $category->display_order = $exchangeCategory->display_order;
                $exchangeCategory->display_order = $tmpDisplayOrder;

                $exchangeCategory->save();
            }
        }

        return $category->save();
    }

    /**
     * Delete category
     *
     * @param string $categoryId
     *
     * @return int affected rows
     */
    public function delCatetory(string $categoryId) : int {
        // todo check products
        $category = CategoryModel::find($categoryId);
        if ($category) {
            return 0;
        }

        $subCategoryCount = CategoryModel::where('parent_id', $categoryId)->count();
        if ($subCategoryCount) {
            throw new ProductCategoryCantDeleteException(
                sprintf('"%s"有子类别，请先删除子类别', $category->name)
            );
        }

        return CategoryModel::where('id', $categoryId)->delete();
    }
} 
