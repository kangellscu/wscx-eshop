<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\UserComment as UserCommentModel;

class UserCommentService 
{
    /**
     * List all user comments
     *
     * @param int $page
     * @param int $size
     *
     * @return Collection       elements as below:
     *                          - comments Collection
     *                              - id uuid
     *                              - name string   comment author name
     *                              - phone ?string comment author phone
     *                              - email ?string comment author email
     *                              - comment string    comment content
     *                              - createdAt Carbon
     *                          - totalPages int
     */
    public function listComments(int $page, int $size) {
        $query = UserCommentModel::query();
        $queryCount = clone($query);

        $offset = ($page - 1) * $size;
        $comments = $query->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($size)
            ->get()
            ->map(function ($comment) {
                return (object) [
                    'id'    => $comment->id,
                    'name'  => $comment->name,
                    'phone' => $comment->phone,
                    'email' => $comment->email,
                    'comment'   => $comment->comment,
                    'createdAt' => $comment->created_at,
                ];
            });
        $totalRecords = $queryCount->count();
        $totalPages = $totalRecords ? (int) ceil($totalRecords / $size) : 1;

        return (object) [
            'comments'      => $comments,
            'totalPages'    => $totalPages,
        ];
    }
}
