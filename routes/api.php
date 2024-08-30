<?php

use App\Http\Controllers\StudentsController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [StudentsController::class,'index']);

Route::post('/students/create', [StudentsController::class,'store']);

Route::get('/students/show/{id}',[StudentsController::class,'show']);

Route::patch('/students/update/{id}',[StudentsController::class,'update']);

Route::delete('/students/delete/{id}',[StudentsController::class,'destroy']);