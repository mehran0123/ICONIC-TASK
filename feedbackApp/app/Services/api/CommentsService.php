<?php

namespace App\Services\api;

use App\Models\Comment;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class CommentsService extends BaseService
{
    public function StoreComment($request)
    {
        try {
            \DB::beginTransaction();
            $comment =  new Comment();
            $comment->user_id = Auth::id();
            $comment->feedback_id  = request()->get('feedback_id');
            $comment->content = request()->get('content');
            $comment->save();
            \DB::commit();
            return $comment;
        } catch (\Exception $e) {
            return $this->addErrors([$e->getMessage()]);
        }
    }

}
