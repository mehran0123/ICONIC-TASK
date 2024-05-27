<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use App\libs\Response\GlobalApiResponse;
use App\libs\Response\GlobalApiResponseCodeBook;
use App\Services\api\FeedBackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private $feedbackService;

    public function __construct(FeedBackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function StoreFeedback(FeedBackRequest $request)
    {
        $data = $this->feedbackService->StoreFeedback($request);
        if ($this->feedbackService->hasError())
            return (new GlobalApiResponse())->error(GlobalApiResponseCodeBook::INVALID_CREDENTIALS, 'INVALID CREDENTIALS', $this->feedbackService->getErrors());
        return (new GlobalApiResponse())->success('Feedback Stored Successfully!', 1,$data);
    }

    public function getFeedbacks()
    {
        $data = $this->feedbackService->getFeedbacks();
        if ($this->feedbackService->hasError())
            return (new GlobalApiResponse())->error(GlobalApiResponseCodeBook::INVALID_CREDENTIALS, 'INVALID CREDENTIALS', $this->feedbackService->getErrors());
        return (new GlobalApiResponse())->success('Feedback Fetched Successfully!', 1,$data);
    }



}
