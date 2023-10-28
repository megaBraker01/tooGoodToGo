<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
//use App\Http\Controllers\IngredientController;

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

Route::apiResource('recipes', RecipeController::class);
//Route::get('/recipes/{id}/ingredients', [RecipeController::class, 'ingredients']);

Route::apiResource('users', UserController::class);
//Route::get('/users/{id}/favorite-recipes', [UserController::class, 'favorite_recipes']);
//Route::apiResource('ingredient', IngredientController::class);