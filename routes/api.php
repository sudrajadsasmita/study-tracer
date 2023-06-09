<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Models\Prodi;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/profile', ProfileController::class);
    Route::put('/profile/{profile}/photo', [ProfileController::class, 'updatePhoto']);
    Route::apiResource('/event', EventController::class);
    Route::get('/get-new/event', [EventController::class, "getNewFiveEvent"]);
    Route::post('/logout', [AuthController::class, "logout"]);
});
Route::apiResource('/faculty', FacultyController::class);
Route::get('/prodi/{faculty_id}/faculty', [ProdiController::class, "getByFaculty"]);
Route::apiResource('/prodi', ProdiController::class);

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
