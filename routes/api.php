<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeCategoryController; 
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\CommentsController; 
use App\Http\Controllers\ShapeController;


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

// UserInfo 
Route::get('users',[UserInfoController::class,'index']);
Route::post('users',[UserInfoController::class,'store']);
Route::get('users/{id}',[UserInfoController::class,'show']); 
Route::get('users/{id}/edit',[UserInfoController::class,'edit']); 
Route::put('users/{id}/edit',[UserInfoController::class,'update']);
Route::delete('users/{id}/delete',[UserInfoController::class,'destroy']);

// comments 
Route::get('comments',[CommentsController::class,'index']);
Route::post('comments',[CommentsController::class,'store']);
Route::get('comments/{id}',[CommentsController::class,'show']);
Route::get('comments/{id}/edit',[CommentsController::class,'edit']);
Route::put('comments/{id}/edit',[CommentsController::class,'update']); 
Route::delete('comments/{id}/delete',[CommentsController::class,'destroy']); 

// About shape 
Route::get('about_me',[ShapeController::class,'index']);
Route::post('about_me',[ShapeController::class,'store']); 
Route::get('about_me/{id}/edit',[ShapeController::class,'edit']);
Route::put('about_me/{id}/edit',[ShapeController::class,'update']);
