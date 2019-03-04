<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\UserCommentService;

class UserCommentController extends BaseController
{
    /**
     * List all user comments order by published time desc
     */
    public function listAll(
        Request $request,
        UserCommentService $commentService
    ) {
        $this->validate($request, [
            'page'  => 'integer|min:1|max:1000',
            'size'  => 'integer|min:1|max:100',
        ]);

        $page = (int) $request->query->get('page', 1);
        $res = $commentService->listComments(
            $page,
            (int) $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.userComments', [
            'comments'      => $res->comments,
            'page'          => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'    => $res->totalPages,
        ]);
    }
}
