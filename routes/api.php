<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeCategoryController; 


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Recipe
Route::get('recipes',[RecipeController::class,'index']);
Route::post('recipes',[RecipeController::class,'store']); 
Route::get('recipes/{id}',[RecipeController::class,'show']);
Route::get('recipes/{id}/edit',[RecipeController::class,'edit']);
Route::put('recipes/{id}/edit',[RecipeController::class,'update']);
Route::delete('recipes/{id}/delete',[RecipeController::class,'destroy']); 

// Category 
Route::get('categories',[RecipeCategoryController::class,'index']); 
Route::post('categories',[RecipeCategoryController::class,'store']); 
Route::get('categories/{id}',[RecipeCategoryController::class,'show']); 
Route::get('categories/{id}/edit',[RecipeCategoryController::class,'edit']); 
Route::put('categories/{id}/edit',[RecipeCategoryController::class,'update']); 
Route::delete('categories/{id}/delete',[RecipeCategoryController::class,'destroy']);

