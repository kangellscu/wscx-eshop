<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Banner as BannerModel;
use App\Exceptions\Banners\BannerActiveReachMaxThresholdException;

class BannerService
{
    const TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Create banner
     *
     * @param UploadedFile $image
     *
     * @return int affected rows
     */
    public function createBanner(UploadedFile $imageFile) : int {
        $imagePath = $imageFile->store('images/banners');

        return BannerModel::create([
            'image_path'    => $imagePath,
            'begin_time'    => Carbon::createFromFormat(self::TIME_FORMAT, '1990-01-01 00:00:01'),
            'end_time'      => Carbon::createFromFormat(self::TIME_FORMAT, '2999-01-01 00:00:01'),
            'status'        => BannerModel::STATUS_DEACTIVE,
        ]);
    }


    /**
     * List all banners for management
     *
     * @param int $page
     * @param int $size
     *
     * @return Collection   elements as below:
     *                      - activedBanners
     *                          - imageUrl string
     *                      - deactivedBanners
     *                          - imageUrl string
     *                      - totalPages int
     */
    public function listBanners(int $page, int $size) {
        $activedBanners = $this->getActivedBanners();

        $query = BannerModel::query();
        $queryCount = clone($query);
        $offset = ($page - 1) * $size;
        $deactivedBanners = $query->where('status', BannerModel::STATUS_DEACTIVE)
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($banner) {
                return (object) [
                    'id'        => $banner->id,
                    'imageUrl'  => Storage::url($banner->image_path),
                    'beginTime' => $banner->begin_time,
                    'endTime'   => $banner->end_time,
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
        $this->checkActiveBannerThreshold();
        return BannerModel::where('id', $bannerId)
            ->where('status', BannerModel::STATUS_DEACTIVE)
            ->update(['status'  => BannerModel::STATUS_ACTIVE]);
    }

    /**
     * deactivate banner
     *
     * @param string $bannerId
     */
    public function deactivateBanner(string $bannerId) {
        return BannerModel::where('id', $bannerId)
            ->where('status', BannerModel::STATUS_ACTIVE)
            ->update(['status'  => BannerModel::STATUS_DEACTIVE]);
    }

    /**
     * Delete banner
     *
     * @param string $bannerId
     */
    public function delBanner(string $bannerId) {
        $banner = BannerModel::where('id', $bannerId)
            ->where('status', BannerModel::STATUS_DEACTIVE)
            ->first();
        if ($banner) {
            $banner->delete();
            Storage::delete($banner->image_path);
        }
    }

    protected function checkActiveBannerThreshold() {
        $activeCount = BannerModel::where('status', BannerModel::STATUS_ACTIVE)
            ->count();
        if ($activeCount >= BannerModel::ACTIVE_MAX_THRESHOLD) {
            throw new BannerActiveReachMaxThresholdException();
        }
    }

    protected function getActivedBanners() : Collection
    {
        return BannerModel::where('status', BannerModel::STATUS_ACTIVE)
            ->get()
            ->map(function ($banner) {
                return (object) [
                    'id'        => $banner->id,
                    'imageUrl'  => Storage::url($banner->image_path),
                    'beginTime' => $banner->begin_time,
                    'endTime'   => $banner->end_time,
                    'createdAt' => $banner->created_at,
                ];
            });
    }
}
