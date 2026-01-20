<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeReviewController extends Controller
{
    // get 
    public function index(Request $request) 
    {
      $query = Recipe::with('comments');
		
        if($request->filled('category')){
			$query->where('category',$request->category);
		} 

        $recipes = $query->get()->map(function ($item){
          return [
            'id' => $item->id,
            'name'=> $item->name,
            'recipe_image' => asset('storage/'.$item->recipe_image),
            'preparation_time' => $item->preparation_time,
            'cook_time' => $item->cook_time,
            'description' => $item->description,
            'ingredients' => $item->ingredients,
            'category' => $item->category,
            'difficulty' => $item->difficulty,
            'how_to_cook' => $item->how_to_cook,
			'review_count' => $item->comments->count()
			];  
        });

        if($recipes->count() > 0) {
            return response()->json([
                'status' => 200,
                'recipes' => $recipes
            ],200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
        }
    } 
    // Get By Id 
    public function show($id)
    { 

     //$recipes = Recipe::find($id);

	// Indivisual id er jonno comments count shoho dekaitechi chaitechi tai eta use korchi
	 $recipes = Recipe::with('comments.user')->find($id);

      if(!$recipes) {
         return response()->json([
        'success' => false,
        'message' => "No such recipe found",
      ],404);
      }
     
      return response()->json([
        'success' => true,
        'recipes' => [
            'id' => $recipes->id,
            'name'=> $recipes->name,
            'recipe_image' =>asset('storage/'.$recipes->recipe_image),
            'preparation_time' => $recipes->preparation_time,
            'cook_time' => $recipes->cook_time,
            'description' => $recipes->description,
            'ingredients' => $recipes->ingredients,
            'category' => $recipes->category,
            'difficulty' => $recipes->difficulty,
            'how_to_cook' => $recipes->how_to_cook,
			'review_count' => $recipes->comments->count()
        ],
      ],200);    
    } 
}
