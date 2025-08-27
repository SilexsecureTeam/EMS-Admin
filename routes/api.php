<?php

use App\Http\Controllers\API\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CareerController;
use App\Http\Controllers\API\CompanyInfoController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\EnrolNowController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\PageBlockController;
use App\Http\Controllers\API\PagesController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\StaffHireController;
use App\Http\Controllers\API\ValueController;

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
    Route::get('/users', [RegisterController::class, 'index'])->middleware('superadmin');
    Route::patch('/users/{id}', [RegisterController::class, 'update'])->middleware('superadmin');

    // pages
    Route::get('/pages', [PagesController::class, 'index']);
    Route::post('/page/update', [PagesController::class, 'storeOrUpdate']);
    Route::get('/page/{parent_page}', [PagesController::class, 'showByParent']);
    Route::delete('/page/{parent_page}', [PagesController::class, 'destroyByParent']);

    // pageblocks
    Route::get('page-block', [PageBlockController::class, 'index']);
    Route::post('page-block', [PageBlockController::class, 'storeOrUpdate']);
    Route::delete('page-block', [PageBlockController::class, 'destroy']);

    // company info
    Route::get('/company-info', [CompanyInfoController::class, 'index']);
    Route::post('/company-info', [CompanyInfoController::class, 'storeOrUpdate']);
    Route::delete('/company-info', [CompanyInfoController::class, 'destroy']);
    // values
    Route::get('values', [ValueController::class, 'index']);
    Route::post('values', [ValueController::class, 'store']);
    Route::get('values/{value}', [ValueController::class, 'show']);
    Route::patch('values/{value}', [ValueController::class, 'update']);
    Route::delete('values/{value}', [ValueController::class, 'destroy'])->middleware('superadmin');

    // programs
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/{slug}', [ProgramController::class, 'show']);
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::patch('/programs/{slug}', [ProgramController::class, 'update']);
    Route::delete('/programs/{slug}', [ProgramController::class, 'destroy']);

    Route::post('/program-reviews', [ReviewController::class, 'store']);
    Route::get('/admin/program-reviews', [ReviewController::class, 'indexAdmin']);
    // Route::patch('/program-reviews/{review}', [ReviewController::class, 'update']);
    Route::patch('/reviews/{id}/featured', [ReviewController::class, 'updateFeatured'])->middleware('superadmin');
    Route::delete('/program-reviews/{id}', [ReviewController::class, 'destroy'])->middleware('superadmin');


    // blog
    Route::get('blogs', [BlogController::class, 'index']);
    Route::post('blogs', [BlogController::class, 'store']);
    Route::get('blogs/{slug}', [BlogController::class, 'show']);
    Route::patch('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])->middleware('superadmin');
    // career
    Route::get('careers', [CareerController::class, 'index']);
    Route::post('careers', [CareerController::class, 'storeOrUpdate']);
    // Route::delete('careers/{id}', [CareerController::class, 'destroy']);
    // Gallery
    Route::get('gallery', [GalleryController::class, 'index']);
    Route::post('gallery', [GalleryController::class, 'store']);
    Route::patch('gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->middleware('superadmin');
    // enrol now
    Route::get('/enrol-now', [EnrolNowController::class, 'show']);
    Route::post('/enrol-now', [EnrolNowController::class, 'storeOrUpdate']);
    // contact
    Route::get('/contact', [ContactController::class, 'index']);
    // staffhire
    Route::get('/staff-hires', [StaffHireController::class, 'index']);   // list all
    Route::get('/staff-hires/{id}', [StaffHireController::class, 'show']); // single
    Route::delete('/staff-hires/{id}', [StaffHireController::class, 'destroy'])->middleware('superadmin'); // delete
});

// pages
Route::get('/page/{parent_page}', [PagesController::class, 'showByParent']);

// pageblocks
Route::get('page-block', [PageBlockController::class, 'index']);
// programs
Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index']);
    Route::get('{slug}', [ProgramController::class, 'show']);
});

// values
Route::get('values', [ValueController::class, 'index']);

// company info
Route::get('/company-info', [CompanyInfoController::class, 'index']);

// reviews
Route::get('/program-reviews', [ReviewController::class, 'index']);
Route::post('/program-reviews', [ReviewController::class, 'store']);

// blog
Route::get('blogs/top-stories', [BlogController::class, 'topStories']);
Route::get('blogs/{slug}', [BlogController::class, 'show']); // Show single blog
Route::get('blogs', [BlogController::class, 'index']);

// careers
Route::get('careers', [CareerController::class, 'index']);

// enrol
Route::get('/enrol-now', [EnrolNowController::class, 'show']);
Route::get('/enrol-now/download/{id}', [EnrolNowController::class, 'download']);

// gallery
Route::get('gallery', [GalleryController::class, 'index']);

// contact
Route::post('/contact', [ContactController::class, 'store']);

// staff hire
Route::post('/staff-hires', [StaffHireController::class, 'store']);
