<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\UserController;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 Route::post('register', [AuthController::class, 'register']);
 Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//test polymorphic
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'getAllUsersWithRoles']);
    Route::post('/', [UserController::class, 'store'])->name('users.store');;
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.delete');;
    Route::get('/{user}/roles', [UserController::class, 'getUserRoles']);
    Route::get('/school/{school}', [UserController::class, 'getSchoolUsers']);
    Route::get('/by-context', [UserController::class, 'getUsersByContextAndRole']);
    Route::get('/classroom/{classroom}', [UserController::class, 'getClassroomUsers']);
});

Route::prefix('schools')->group(function () {
    Route::get('/', [SchoolController::class, 'index']);
    Route::post('/', [SchoolController::class, 'store']);
    Route::get('/{school}', [SchoolController::class, 'show']);
    Route::put('/{school}', [SchoolController::class, 'update']);
    Route::get('/{school}/families', [SchoolController::class, 'getAllFamiliesInSchool']);
});
