<?php

namespace App\Http\Controllers\Mobiles;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class IndexController extends BaseController
{
    /**
     * Show index page
     */
    public function index(
        Request $request
    ) {
        return view('mobile.index');
    }
}
