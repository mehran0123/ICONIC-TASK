<?php

namespace App\Services\api;

use App\Models\Feedback;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\password;

class FeedBackService extends BaseService
{
    public function StoreFeedback($request)
    {
        try {
            \DB::beginTransaction();
             $feedback =  new Feedback();
             $feedback->user_id = Auth::id();
             $feedback->product_title = request()->get('product_title');
             $feedback->description = request()->get('description');
             $feedback->category = request()->get('category');
             $feedback->save();
            \DB::commit();
            return $feedback;
        } catch (\Exception $e) {
            return $this->addErrors([$e->getMessage()]);
        }
    }

    public function getFeedbacks()
    {

        try {
            $feedbacks = Feedback::with('user:id,name')->with(['comments' => function ($q) {
                $q->select('id','user_id','feedback_id','content','created_at')->with('user:id,name');
            }])->paginate(10);
            return $feedbacks;
        } catch (\Exception $e) {
            return $this->addErrors([$e->getMessage()]);
        }
    }




}
