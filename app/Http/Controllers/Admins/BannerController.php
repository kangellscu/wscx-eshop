<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\BannerService;

class BannerController extends BaseController
{
    /**
     * List all banners
     */
    public function listAll(
        Request $request,
        BannerService $bannerService
    ) {
        $this->validate($request, [
            'page'  => 'integer|min:1|max:1000',
            'size'  => 'integer|min:1|max:100',
        ]);
        $page = (int) $request->query->get('page', 1);
        $res = $bannerService->listBanners(
            $page,
            (int) $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.banners', [
            'activedBanners'    => $res->$activedBanners,
            'deactivedBanners'   => $res->$deactivedBanners,
            'totalPages'        => $res->totalPages,
        ]);
    }

    /**
     * Create banner
     */
    public function createBanner() {
        // todo
    }

    /**
     * Activate banner
     */
    public function activateBanner(
        Request $request,
        BannerService $bannerService,
        string $id
    ) {
        $this->request->set('bannerId', $id);
        $this->validate($request, [
            'bannerId'  => 'required|uuid',
        ]);

        $bannerService->activateBanner($bannerId);

        return back();
    }

    /**
     * Activate banner
     */
    public function deactivateBanner(
        Request $request,
        BannerService $bannerService,
        string $id
    ) {
        $this->request->set('bannerId', $id);
        $this->validate($request, [
            'bannerId'  => 'required|uuid',
        ]);

        $bannerService->deactivateBanner($bannerId);

        return back();
    }
}
