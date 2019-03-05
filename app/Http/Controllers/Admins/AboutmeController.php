<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\AboutmeService;

class AboutmeController extends BaseController
{
    /**
     * Show aboutme page
     */
    public function showPage(
        Request $request,
        AboutmeService $aboutmeService
    ) {
        $aboutme = $aboutmeService->getAboutme();
        return view('admin.aboutme', [
            'aboutme'   => $aboutme,
        ]);
    }

    /**
     * Edit aboutme
     */
    public function setAboutme(
        Request $request,
        AboutmeService $aboutmeService
    ) {
        $this->validate($request, [
            'image' => 'required|max:2000|mimes:jpeg,png,jpg',
        ]);

        $aboutmeService->setAboutme($request->file('image'));

        return back();
    }
}
