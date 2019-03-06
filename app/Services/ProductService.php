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

    /**
     * Get one product
     *
     * @param string $productId
     *
     * @return ?object          properties as below:
     *                          - id string
     *                          - brandId string
     *                          - categoryId string
     *                          - briefDesc string
     *                          - thumbnailUrl string
     *                          - status int
     *                          - statusDesc string
     */
    public function getProduct(string $productId) {
        $sku = SkuModel::find($productId);

        return is_null($sku) ? null : (object) [
            'id'        => $product->id,
            'brandId'   => $product->brand_id,
            'categoryId'    => $product->category_id,
            'briefDesc' => $product->brief_description,
            'thumbnailUrl'  => Storage::url($product->thumbnail_path),
            'status'        => $product->status,
            'statusDesc'    => $product->statusDesc(),
        ];
    }

    /**
     * Create new product
     *
     * @param string $name
     * @param string $brandId
     * @param string $categoryId
     * @param string $briefDesc
     * @param UploadedFile $thumbnail
     *
     * @return string product id
     */
    public function createProduct(
        string $name,
        string $brandId,
        string $categoryId,
        string $briefDesc,
        UploadedFile $thumbnail
    ) : string {
        $sku = SkuModel::create([
            'name'              => $name,
            'brand_id'          => $brandId,
            'category_id'       => $categoryId,
            'brief_description' => $briefDesc,
            'thumbnail_path'    => $thumbnail->store('images/skus'),
            'status'            => SkuModel::STATUS_UNSHELVE,
        ]);

        return $sku->id;
    }

    /**
     * Edit product
     *
     * @param string $productId
     * @param string $name
     * @param string $brandId
     * @param string $categoryId
     * @param string $briefDesc
     * @param ?UploadedFile $thumbnail
     *
     * @return int affected rows
     */
    public function editProduct(
        string $productId,
        string $name,
        string $brandId,
        string $categoryId,
        string $briefDesc,
        ?UploadedFile $thumbnail
    ) : int {
        $sku = SkuModel::find($productId);
        if ( ! $sku) {
            return 0;
        }

        $sku->name = $name;
        $sku->brand_id = $brandId;
        $sku->category_id = $categoryId;
        $sku->brief_description = $briefDesc;
        if ($thumbnail) {
            $oldThumbnailPath = $sku->thumbnail_path;
            $sku->thumbnail_path = $thumbnail->store('images/skus');
            Storage::delete($oldThumbnailPath);
        }

        return $sku->save();
    }

    /**
     * Delete product
     *
     * @param string $productId
     *
     * @return void
     */
    public function delProduct(string $productId) {
        $sku = SkuModel::find($productId);
        if ($sku) {
            $thumbnailPath = $sku->thumbnail_path;
            $sku->delete();
            Storage::delete($thumbnailPath);
        }
    }
}
