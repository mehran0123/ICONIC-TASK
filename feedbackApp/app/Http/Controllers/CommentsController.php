<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\Http\Requests\StoreCommentsRequest;
use App\libs\Response\GlobalApiResponse;
use App\libs\Response\GlobalApiResponseCodeBook;
use App\Services\api\CommentsService;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    private $commentsService;

    public function __construct(CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;

    }

    public function StoreComment(StoreCommentsRequest $request)
    {
        $data = $this->commentsService->StoreComment($request);
        if ($this->commentsService->hasError())
            return (new GlobalApiResponse())->error(GlobalApiResponseCodeBook::INVALID_FORM_INPUTS, 'INVALID CREDENTIALS', $this->commentsService->getErrors());
        return (new GlobalApiResponse())->success('Comment Stored Successfully!', 1,$data);
    }

}
