<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Banner as BannerModel;

class UserCommentService 
{
    /**
     * List all banners for management
     *
     * @param int $page
     * @param int $size
     *
     * @return Collection   elements as below:
     *                      - activedBanners
     *                          - image_url string
     *                      - deactivedBanners
     *                          - image_url string
     *                      - totalPages int
     */
    public function listBanners(int $page, int $size) {
        $activedBanners = $this->getActivedBanners();

        $query = BannerModel::query();
        $queryCount = clone($query);
        $offset = ($page - 1) * $size;
        $banners = $query->where('status', BannerModel::STATUS_DEACTIVE)
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($banner) {
                return (object) [
                    'id'        => $banner->id,
                    'image_url' => $banner->image_url,
                    'createdAt' => $banner->created_at,
                ];
            });
        $totalRecords = $queryCount->count();
        $totalPages = $totalRecords ? (int) ceil($totalRecords / $size) : 1;

        return (object) [
            'activedBanners'    => $activedBanners,
            'deactivedBanners'  => $deactivedBanners,
            'totalPages'        => $totalPages,
        ];
    }

    /**
     * activate banner
     *
     * @param string $bannerId
     */
    public function activateBanner(string $bannerId) {
        return BannerModel::where('id', $bannerId)
            ->where('status', BannerModel::STATUS_DEACTIVE)
            ->update('status', BannerModel::STATUS_ACTIVE);
    }

    /**
     * deactivate banner
     *
     * @param string $bannerId
     */
    public function deactivateBanner(string $bannerId) {
        return BannerModel::where('id', $bannerId)
            ->where('status', BannerModel::STATUS_ACTIVE)
            ->update('status', BannerModel::STATUS_DEACTIVE);
    }

    protected function getActivedBanners() : Collection
    {
        return BannerModel::where('status', BannerModel::STATUS_ACTIVE)
            ->get()
            ->map(function ($banner) {
                return (object) [
                    'id'    => $banner->id,
                    'imageUrl'  => $banner->image_url,
                    'beginTime' => $banner->begin_time,
                    'endTime'   => $banner->end_time,
                ];
            });
    }
}
