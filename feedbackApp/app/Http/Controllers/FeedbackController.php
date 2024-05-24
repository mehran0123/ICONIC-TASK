<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return Feedback::all();
    }

    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return response()->json($feedback, 201);
    }

    public function show($id)
    {
        return Feedback::findOrFail($id);
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update($request->validated());

        return response()->json($feedback);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json(null, 204);
    }
}
