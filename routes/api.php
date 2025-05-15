<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\SmsController;


/**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Get list of users",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Users not found"
 *     )
 * )
 */
Route::get('/users', [TestController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/upload', [AuthController::class, 'upload']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/send-sms', [SmsController::class, 'send']);
