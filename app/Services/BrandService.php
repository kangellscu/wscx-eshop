<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Brand as BrandModel;

class BrandService 
{
    /**
     * List all brands
     *
     * @param int $page
     * @param int $size
     *
     * @return Collection   elements as below
     *                      - id string
     *                      - name string
     *                      - nameCapital string
     *                      - logoUrl string
     *                      - story string
     */
    public function listBrands(int $page, int $size) : Collection {
        $query = BrandModel::query();
        $queryCount = clone($query);
        $offset = ($page - 1) * $size;
        $brands = $query->orderBy('name_capital')
            ->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($brand) {
                return (object) [
                    'id'            => $brand->id,
                    'name'          => $brand->name,
                    'nameCapital'   => $brand->name_capital,
                    'logoUrl'       => Storage::url($brand->logo_path),
                    'story'         => $brand->story,
                ];
            });
        $totalRecords = $queryCount->count();
        $totalPages = $totalRecords ? (int) ceil($totalRecords / $size) : 1;

        return (object) [
            'brands'        => $brands,
            'totalPages'    => $totalPages,
        ];
    }

    /**
     * Get Brand by id
     *
     * @param string $brandId
     *
     * @return ?object   elements as below:
     *                  - id string
     *                  - name string
     *                  - nameCapital string
     *                  - logoUrl string
     *                  - story string
     */
    public function getBrand(string $brandId) {
        $brand = BrandModel::find($brandId);

        return is_null($brand) ?: (object) [
            'id'            => $brand->id,
            'name'          => $brand->name,
            'nameCapital'   => $brand->name_capital,
            'logoUrl'       => Storage::url($brand->logo_path),
            'story'         => $brand->story,
        ];
    }

    /**
     * Create brand
     *
     * @param string $nameCapital
     * @param string $name
     * @param string $story
     * @param UploadedFile $logo
     *
     * @return int  affected num
     */
    public function createBrand(
        string $nameCapital,
        string $name,
        string $story,
        UploadedFile $logo
    ) : int {
        $logoPath = $logo->store('images/brands');

        return BrandModel::create([
            'name_capital'  => $nameCapital,
            'name'          => $name,
            'story'         => $story,
            'logo_path'     => $logoPath,
        ]);
    }

    /**
     * Edit brand
     *
     * @param string $brandId
     * @param string $nameCapital
     * @param string $name
     * @param string $story
     * @param ?UploadedFile $logo
     *
     * @return int  affected num
     */
    public function editBrand(
        string $brandId,
        string $nameCapital,
        string $name,
        string $story,
        ?UploadedFile $logo
    ) : int {
        $brand = BrandModel::find($brandId);
        if ( ! $brand) {
            return 0;
        }

        $brand->name = $name;
        $brand->name_capital = $nameCapital;
        $brand->story = $story;
        if ($logo) {
            $oldLogoPath = $brand->logo_path;
            $brand->logo_path = $logo->store('images/brands');
            Storage::delete($oldLogoPath);
        }
        return $brand->save();
    }

    /**
     * Delete brand
     *
     * @param string $brandId
     *
     * @return void
     */
    public function delBrand(string $brandId) {
        // todo process products
        $brand = BrandModel::find($brandId);
        if ($brand) {
            $logoPath = $brand->logo_path;
            $brand->delete();
            Storage::delete($logoPath);
        }
    }
}
