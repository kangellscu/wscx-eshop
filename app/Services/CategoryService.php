<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Category as CategoryModel;
use App\Models\Sku as SkuModel;
use App\Exceptions\Products\ProductCategoryCantDeleteException;
use App\Exceptions\Products\ProductCategoryNotExistsException;
use App\Exceptions\Products\ProductExistsException;

class CategoryService
{
    /**
     * List all categories
     *
     * @return Collection       elements as below:
     *                          - id string
     *                          - name string
     *                          - level int
     *                          - subs Collection
     *                              - id string
     *                              - name string
     *                              - level int
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
                                'level' => $subCategory->level,
                                'name'  => $subCategory->name,
                            ];
                        });

                return (object) [
                    'id'    => $topCategory->id,
                    'name'  => $topCategory->name,
                    'level' => $topCategory->level,
                    'subs'  => $subs,
                ];
            });
    }

    /**
     * Get index products
     *
     * @return Collection   elements as below:
     *                      - id string
     *                      - name string
     *                      - level int
     *                      - products Collection
     *                          - id string
     *                          - name string
     *                          - thumbnailUrl string
     */
    public function getCategoryProducts(int $level, int $maxDisplayNum) {
        return CategoryModel::with(['products' => function ($query) {
                $query->orderBy('created_at');
            }])->where('level', $level)
            ->orderBy('display_order')
            ->get()
            ->map(function ($category) use ($maxDisplayNum) {
                return (object) [
                    'id'    => $category->id,
                    'name'  => $category->name,
                    'level' => $category->level,
                    'products'  => $category->products()->take($maxDisplayNum)->get()->map(function ($product) {
                                    return (object) [
                                        'id'    => $product->id,
                                        'name'  => $product->name,
                                        'thumbnailUrl'  => Storage::url($product->thumbnail_path),
                                    ];
                                }),
                ];
            });
    }

    /**
     * Get all categories
     *
     * @return Collection   elements as below:
     *                      - id string
     *                      - parentId string
     *                      - name string
     */
    public function getCategories() : Collection {
        return CategoryModel::orderBy('display_order')
            ->get()
            ->map(function ($category) {
                return (object) [
                    'id'        => $category->id,
                    'parentId'  => $category->parent_id,
                    'name'      => $category->name,
                    'level'     => $category->level,
                ];
            });
    }

    /**
     * Get top categories
     *
     * @return Collection   elements as below:
     *                      - id string
     *                      - name string
     */
    public function getTopCategories() : Collection {
        return CategoryModel::where('level', CategoryModel::TOP_CATEGORY_LEVEL)
            ->orderBy('display_order')
            ->get()
            ->map(function ($category) {
                return (object) [
                    'id'        => $category->id,
                    'name'      => $category->name,
                    'level'     => $category->level,
                ];
            });
    }

    /**
     * Get all sub categories 
     * @return Collection   elements as below:
     *                      - id string
     *                      - parentId string
     *                      - name string
     */
    public function getSubCategories() : Collection {
        return CategoryModel::where('level', CategoryModel::SUB_CATEGORY_LEVEL)
            ->get()
            ->map(function ($category) {
                return (object) [
                    'id'        => $category->id,
                    'parentId'  => $category->parent_id,
                    'name'      => $category->name,
                    'level'     => $category->level,
                ];
            });
    }

    /**
     * @param string $categoryId
     *
     * @return ?object  properties as below
     *                  - id string
     *                  - parentId ?string
     *                  - name string
     */
    public function getCategory(string $categoryId) {
        $category = CategoryModel::find($categoryId);

        return is_null($category) ? null : (object) [
            'id'        => $category->id,
            'parentId'  => $category->parent_id,
            'name'      => $category->name,
            'level'     => $category->level,
        ];
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
        $parentCategory = null;
        if ($parentId) {
            $parentCategory = CategoryModel::find($parentId);
            if ( ! $parentCategory) {
                throw new ProductCategoryNotExistsException('该子类别没有所属的父类别');
            }
        }

        $maxDisplayOrder = CategoryModel::max('display_order') ?: 0;
        $level = $parentCategory ?
            CategoryModel::nextLevel($parentCategory->level) :
            CategoryModel::TOP_CATEGORY_LEVEL;

        CategoryModel::create([
            'name'          => $name,
            'parent_id'     => $parentId,
            'level'         => $level,
            'display_order' => $maxDisplayOrder + CategoryModel::DISPLAY_ORDER_STEP,
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
        if ( ! empty($moveDirection)) {
            $tmpDisplayOrder = $category->display_order;
            if ($moveDirection > 0) {
                $query = CategoryModel::where('display_order', '>', $tmpDisplayOrder);
                if ($category->parent_id) {
                    $query->where('parent_id', $category->parent_id);
                } else {
                    $query->whereNull('parent_id');
                }

                $exchangeCategory = $query->orderBy('display_order')->first();
            } else {
                $query = CategoryModel::where('display_order', '<', $tmpDisplayOrder);
                if ($category->parent_id) {
                    $query->where('parent_id', $category->parent_id);
                } else {
                    $query->whereNull('parent_id');
                }
                $exchangeCategory = $query->orderBy('display_order', 'desc')->first();
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
        $category = CategoryModel::find($categoryId);
        if ( ! $category) {
            return 0;
        }

        $subCategoryCount = CategoryModel::where('parent_id', $categoryId)->count();
        if ($subCategoryCount) {
            throw new ProductCategoryCantDeleteException(
                sprintf('"%s"有子类别，请先删除子类别', $category->name)
            );
        }

        if (SkuModel::where('category_id', $categoryId)->count()) {
            throw new ProductExistsException('该类别下仍有产品未删除，请先删除产品');
        }

        return CategoryModel::where('id', $categoryId)->delete();
    }
} 
