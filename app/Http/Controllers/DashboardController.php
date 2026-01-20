<?php

namespace App\Http\Controllers;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Comments;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recipeCount = Recipe::count();
        $categoryCount = Category::count();
        $commentsCount = Comments::count();
        return response()->json([
            'recipeCount' => $recipeCount,
            'categoryCount' => $categoryCount,
            'commentsCount' => $commentsCount
        ]);
    }
}
