<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Sku as SkuModel;

class ProductService 
{
    /**
     * List products
     *
     * @param ?string $categoryId
     * @param ?string $brandId
     * @param int $page
     * @param int $size
     *
     * @return object   elements as below
     *                  - products Collection
     *                      - id string
     *                      - brandId string
     *                      - categoryId string
     *                      - briefDesc string
     *                      - thumbnailUrl string
     *                      - status int
     *                      - statusDesc string
     *                  - totalPages int
     */
    public function listProducts(
        ?string $categoryId,
        ?string $brandId,
        int $page,
        int $size
    ) {
        $query = SkuModel::query();
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }
        $queryCount = clone($query);
        $offset = ($page - 1) * $size;
        $products = $query->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($product) {
                return (object) [
                    'id'        => $product->id,
                    'brandId'   => $product->brand_id,
                    'categoryId'    => $product->category_id,
                    'briefDesc' => $product->brief_description,
                    'thumbnailUrl'  => Storage::url($product->thumbnail_path),
                    'status'        => $product->status,
                    'statusDesc'    => $product->statusDesc(),
                ];
            });
        $totalRecords = $queryCount->count();
        $totalPages = $totalRecords ? (int) ceil($totalRecords / $size) : 1;

        return (object) [
            'products'      => $products,
            'totalPages'    => $totalPages,
        ];
    }
}
