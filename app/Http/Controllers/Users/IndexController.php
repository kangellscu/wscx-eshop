<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\IndexService;

class IndexController extends BaseController
{
    /**
     * Show index page
     */
    public function index(IndexService $indexService) {
        return view('web.index');
    }
}
