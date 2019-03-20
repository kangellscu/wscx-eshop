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
     *                      - name string
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
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'brandId'       => $product->brand_id,
                    'categoryId'    => $product->category_id,
                    'briefDesc'     => $product->brief_description,
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
     * Get all products
     *
     * @param ?string $brandId
     * @param ?string $categoryId
     *
     * @return Collection elements as below:
     *                      - id string
     *                      - name string
     *                      - briefDesc string
     *                      - thumbnailUrl string
     */
    public function getAllProducts(
        ?string $brandId = null,
        ?string $categoryId = null
    ) : Collection {
        $query = SkuModel::with('category')
            ->where('status', SkuModel::STATUS_SHELVE);
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        return $query->get()
            ->map(function ($product) {
                return (object) [
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'brandId'       => $product->brand_id,
                    'categoryId'    => $product->category_id,
                    'parentId'      => $product->category->parent_id,
                    'briefDesc'     => $product->brief_description,
                    'thumbnailUrl'  => Storage::url($product->thumbnail_path),
                ];
            });
    }

    /**
     * Get product status map
     *
     * @return dict     key is status, value is status desc
     */
    public function getStatusMap() {
        return SkuModel::statusMap();
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
     *                          - name string
     *                          - briefDesc string
     *                          - thumbnailUrl string
     *                          - status int
     *                          - statusDesc string
     */
    public function getProduct(string $productId) {
        $sku = SkuModel::find($productId);

        return is_null($sku) ? null : (object) [
            'id'            => $sku->id,
            'brandId'       => $sku->brand_id,
            'categoryId'    => $sku->category_id,
            'name'          => $sku->name,
            'briefDesc'     => $sku->brief_description,
            'thumbnailUrl'  => Storage::url($sku->thumbnail_path),
            'docSpecificationUrl'   => $sku->doc_specification_path ?
                Storage::url($sku->doc_specification_path) : null,
            'docUrl'        => $sku->doc_path ? Storage::url($sku->doc_path) : null,
            'docInstructionUrl' => $sku->doc_instruction_path ?
                Storage::url($sku->doc_instruction_path) : null,  
            'docOtherUrl'   => $sku->doc_other_path ?
                Storage::url($sku->doc_other_path) : null,     
            'status'        => $sku->status,
            'statusDesc'    => $sku->statusDesc(),
        ];
    }

    /**
     * Create new product
     *
     * @param string $name
     * @param string $brandId
     * @param string $categoryId
     * @param string $briefDesc
     * @param int $status
     * @param UploadedFile $thumbnail
     * @param ?UploadedFile $docSpecification
     * @param ?UploadedFile $doc
     * @param ?UploadedFile $docInstruction
     * @param ?UploadedFile $docOther
     *
     * @return string product id
     */
    public function createProduct(
        string $name,
        string $brandId,
        string $categoryId,
        string $briefDesc,
        int $status,
        UploadedFile $thumbnail,
        ?UploadedFile $docSpecification,
        ?UploadedFile $doc,
        ?UploadedFile $docInstruction,
        ?UploadedFile $docOther
    ) : string {
        $sku = SkuModel::create([
            'name'              => $name,
            'brand_id'          => $brandId,
            'category_id'       => $categoryId,
            'brief_description' => $briefDesc,
            'status'            => $status,
            'thumbnail_path'    => $thumbnail->store('images/skus'),
            'doc_specification_path'    => $docSpecification ?
                $docSpecification->store('docs/skus') : null,
            'doc_path'              => $doc ?
                $doc->store('docs/skus') : null,
            'doc_instruction_path'  => $docInstruction ?
                $docInstruction->store('docs/skus') : null,
            'doc_other_path'        => $docOther ?
                $docOther->store('docs/skus') : null,
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
     * @param int $status
     * @param ?UploadedFile $thumbnail
     * @param ?UploadedFile $docSpecification
     * @param ?UploadedFile $doc
     * @param ?UploadedFile $docInstruction
     * @param ?UploadedFile $docOther
     *
     * @return int affected rows
     */
    public function editProduct(
        string $productId,
        string $name,
        string $brandId,
        string $categoryId,
        string $briefDesc,
        int $status,
        ?UploadedFile $thumbnail,
        ?UploadedFile $docSpecification,
        ?UploadedFile $doc,
        ?UploadedFile $docInstruction,
        ?UploadedFile $docOther
    ) : int {
        $sku = SkuModel::find($productId);
        if ( ! $sku) {
            return 0;
        }

        $sku->name = $name;
        $sku->brand_id = $brandId;
        $sku->category_id = $categoryId;
        $sku->brief_description = $briefDesc;
        $sku->status = $status;
        if ($thumbnail) {
            $oldThumbnailPath = $sku->thumbnail_path;
            $sku->thumbnail_path = $thumbnail->store('images/skus');
            Storage::delete($oldThumbnailPath);
        }
        if ($docSpecification) {
            $oldDocSpecificationPath = $sku->doc_specification_path;
            $sku->doc_specification_path = $docSpecification->store('docs/skus');
            if ($oldDocSpecificationPath) {
                Storage::delete($oldDocSpecificationPath);
            }
        }
        if ($doc) {
            $oldDocPath = $sku->doc_path;
            $sku->doc_path = $doc->store('docs/skus');
            if ($oldDocPath) {
                Storage::delete($oldDocPath);
            }
        }
        if ($docInstruction) {
            $oldDocInstructionPath = $sku->doc_instruction_path;
            $sku->doc_instruction_path = $docInstruction->store('docs/skus');
            if ($oldDocInstructionPath) {
                Storage::delete($oldDocInstructionPath);
            }
        }
        if ($docOther) {
            $oldDocOtherPath = $sku->doc_other_path;
            $sku->doc_other_path = $docOther->store('docs/skus');
            if ($oldDocOtherPath) {
                Storage::delete($oldDocOtherPath);
            }
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
            $docSpecificationPath = $sku->doc_specification_path;
            $docPath = $sku->doc_path;
            $docInstructionPath = $sku->doc_instruction_path;
            $docOtherPath = $sku->doc_other_path;
            $sku->delete();
            Storage::delete($thumbnailPath);
            if ($docSpecificationPath) {
                Storage::delete($docSpecificationPath);
            }
            if ($docPath) {
                Storage::delete($docPath);
            }
            if ($docInstructionPath) {
                Storage::delete($docInstructionPath);
            }
            if ($docOtherPath) {
                Storage::delete($docOtherPath);
            }
        }
    }
}
