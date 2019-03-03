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
            'activedBanners'    => $res->activedBanners,
            'deactivedBanners'  => $res->deactivedBanners,
            'page'              => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'        => $res->totalPages,
        ]);
    }

    /**
     * Create banner
     */
    public function createBanner(
        Request $request,
        BannerService $bannerService
    ) {
        $this->validate($request, [
            'image' => 'required|max:300|mimes:jpeg,png,jpg',
        ]);

        $bannerService->createBanner(
            $request->file('image')
        );

        return back();
    }

    /**
     * Activate banner
     */
    public function activateBanner(
        Request $request,
        BannerService $bannerService,
        string $id
    ) {
        $request->request->set('bannerId', $id);
        $this->validate($request, [
            'bannerId'  => 'required|uuid',
        ]);

        $bannerService->activateBanner($request->request->get('bannerId'));

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
        $request->request->set('bannerId', $id);
        $this->validate($request, [
            'bannerId'  => 'required|uuid',
        ]);

        $bannerService->deactivateBanner($request->request->get('bannerId'));

        return back();
    }

    /**
     * Delete banner
     */
    public function delBanner(
        Request $request,
        BannerService $bannerService,
        string $id
    ) {
        $request->request->set('bannerId', $id);
        $this->validate($request, [
            'bannerId'  => 'required|uuid',
        ]);

        $bannerService->delBanner($request->request->get('bannerId'));

        return back();
    }
}
