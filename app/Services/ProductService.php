<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Sku as SkuModel;
use App\Models\Category as CategoryModel;

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
     *                      - url string
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
        $category = CategoryModel::find($categoryId);
        if ($category) {
            $categoryIds = [$category->id];
            if ($category->level == CategoryModel::TOP_CATEGORY_LEVEL) {
                $categoryIds = CategoryModel::where('parent_id', $category->id)
                    ->get()
                    ->pluck('id')
                    ->toArray();
            }
            $query->whereIn('category_id', $categoryIds);
        }
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }
        $queryCount = clone($query);
        $offset = ($page - 1) * $size;
        $products = $query->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($product) {
                return (object) [
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'brandId'       => $product->brand_id,
                    'categoryId'    => $product->category_id,
                    'briefDesc'     => $product->brief_description,
                    'url'           => $product->url,
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
     *                      - url string
     *                      - docSpecificationUrl string
     *                      - docUrl string
     *                      - docInstructionUrl string
     *                      - docOtherUrl string
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
                    'url'           => $product->url,
                    'contactName'   => $product->contact_name,
                    'contactPhone'  => $product->contact_phone,
                    'thumbnailUrl'  => Storage::url($product->thumbnail_path),
                    'docSpecificationUrl'   => $product->doc_specification_path ?
                        Storage::url($product->doc_specification_path) : null,
                    'docUrl'        => $product->doc_path ?
                        Storage::url($product->doc_path) : null,
                    'docInstructionUrl' => $product->doc_instruction_path ?
                        Storage::url($product->doc_instruction_path) : null,
                    'docOtherUrl'   => $product->doc_other_path ?
                        Storage::url($product->doc_other_path) : null,
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
            'url'           => $sku->url,
            'contactName'   => $sku->contact_name,
            'contactPhone'  => $sku->contact_phone,
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
     * @param ?string $url
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
	?string $contactName,
	?string $contactPhone,
        ?string $url,
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
	    'contact_name'	=> $contactName,
	    'contact_phone'	=> $contactPhone,
            'url'               => $url,
            'thumbnail_path'    => $thumbnail->store('images/skus'),
            'doc_specification_path'    => $docSpecification ?
                $docSpecification->store('docs/skus') : null,
            'doc_path'              => $doc ?
                $doc->store('docs/skus') : null,
            'doc_instruction_path'  => $docInstruction ?
                $docInstruction->store('docs/skus') : null,
            'doc_other_path'        => $docOther ?
                $docOther->store('docs/skus') : null,
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
     * @param ?string $url
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
	?string $contactName,
	?string $contactPhone,
        ?string $url,
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
	$sku->contact_name = $contactName;
	$sku->contact_phone = $contactPhone;
        $sku->url = $url;
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

    /**
     * Get distinct category id
     *
     * @param string $brandId
     *
     * @return Collection       elements as below:
     *                          - id string
     */
    public function getProductsDistinctCategoryIds(string $brandId) : Collection {
        return SkuModel::where('brand_id', $brandId)
            ->where('status', SkuModel::STATUS_SHELVE)
            ->select('category_id')
            ->distinct()
            ->get()
            ->map(function ($product) {
                return (object) [
                    'id'    => $product->category_id,
                ];
            });
    }

    /**
     * Get distinct brand id
     *
     * @param array $ids
     *
     * @return Collection       elements as below:
     *                          - id string     brqnd id
     */
    public function getProductsDistinctBrandIds(array $ids) : Collection {
        return SkuModel::whereIn('category_id', $ids)
            ->where('status', SkuModel::STATUS_SHELVE)
            ->select('brand_id')
            ->distinct()
            ->get()
            ->map(function ($product) {
                return (object) [
                    'id'    => $product->brand_id,
                ];
            });
    }
}
