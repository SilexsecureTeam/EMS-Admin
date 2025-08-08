<?php

use App\Http\Controllers\API\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\PagesController;
use App\Http\Controllers\API\ProgramController;

use function Pest\Laravel\json;
// Route::get('/ping', fn() => response()->json([
//     'status' => true,
//     'message' => 'Alive',
// ]));
Route::fallback(fn() => response()->json([
    'status' => false,
    'message' => 'resource not found',
], 404));

Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify-otp', [LoginController::class, 'verifyOtp']);
Route::post('/forgot-password', [LoginController::class, 'sendResetLink']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/page/update', [PagesController::class, 'storeOrUpdate']);
    Route::get('/page/{parent_page}', [PagesController::class, 'showByParent']);
    // programs
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/{slug}', [ProgramController::class, 'show']);
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::put('/programs/{slug}', [ProgramController::class, 'update']);
    Route::delete('/programs/{slug}', [ProgramController::class, 'destroy']);
});

// programs
Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index']);
    Route::get('{slug}', [ProgramController::class, 'show']);
});
