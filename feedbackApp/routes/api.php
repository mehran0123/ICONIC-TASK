<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('api.logout');
    });
});

Route::prefix('feedback')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store-feedback', [FeedbackController::class, 'StoreFeedback'])->name('storeFeedback');
        Route::get('get-feedbacks', [FeedbackController::class, 'getFeedbacks'])->name('getFeedbacks');
    });
});


Route::prefix('comments')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('store-comment', [CommentsController::class, 'StoreComment'])->name('StoreComment');
        Route::get('get-comment/{feedbackId}', [FeedbackController::class, 'getComments'])->name('getComments');
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function () {
    $metadata['outcome'] = "ERROR";
    $metadata['outcomeCode'] = "404";
    $metadata['numOfRecords'] = "0";
    $metadata['message'] = "URL not found";
    $records = array();
    $errors = array();

    return response()->json([
        '_metadata' => $metadata,
        'records' => $records,
        'errors' => $errors,
    ], 404);
});
