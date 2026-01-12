<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{  
    // Get
    public function index() 
    {
        $recipes = Recipe::all()->map(function ($item){
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
            'how_to_cook' => $item->how_to_cook
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
    // Post 
    public function store(Request $request) 
    {   
		$validator = Validator::make($request->all(),[
			'name' => 'required | string | max:191',
			'recipe_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'preparation_time' => 'required',
			'cook_time' => 'required',
			'description' => 'required | string',
			'ingredients' => 'required | string',
			'category' => 'required | string | max:191',
			'difficulty' => 'required |string | max:191',
			'how_to_cook' => 'required | string'
		]); 
		if ($validator->fails()) {
			return response()->json([
				'success' 	=> false,
				'message' 	=> "Validation failed",
				'errors'	=> $validator->errors()->messages(),
			]);
		}
		// Img file upload
		$image = $request->file('recipe_image');

		$imageName = time().'.'.$image->getClientOriginalExtension();
		
		$image->storeAs('recipeImages',$imageName,'public');

		$recipes = Recipe::create([
			'name' => $request->name,
			'recipe_image' => 'recipeImages/'.$imageName,
			'preparation_time' => $request->preparation_time,
			'cook_time' => $request->cook_time,
			'description' => $request->description,
			'ingredients' => $request->ingredients,
			'category' => $request->category,
			'difficulty' => $request->difficulty,
			'how_to_cook' => $request->how_to_cook
		]);
		//$recipes = Recipe::create($request->all());
		if($recipes) {
			return response()->json([
				'status'=>200,
				'message'=>"recipe created successfully",
			],200);
		} else {
			return response()->json([
				'status'=>500,
				'message'=>"something went wrong",
			],500);
		}
    } 
    // Get by id 
    public function show($id)
    { 
     $recipes = Recipe::find($id);

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
            'how_to_cook' => $recipes->how_to_cook
        ],
      ],200);    
    } 
    // Edit 
    public function edit($id) 
    {
		$recipes = Recipe::find($id); 

		if($recipes) {
		return response()->json([
			'success' => true,
			'recipe' => $recipes
		],200);
		} else {
		return response()->json([
			'success' => false,
			'message' => 'No such found recipe'
		],404);
		}
    } 
    // Update 
    public function update(Request $request,int $id) 
    {
		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:191',
			'recipe_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'preparation_time' => 'sometimes',
			'cook_time' => 'sometimes',
			'description' => 'sometimes|string',
			'ingredients' => 'sometimes|string',
			'category' => 'sometimes|string|max:191',
			'difficulty' => 'sometimes|string|max:191',
			'how_to_cook' => 'required|string'
		]);
		if ($validator->fails()) {
			return response()->json([
				'success' 	=> false,
				'message' 	=> "Validation failed",
				'errors'	=> $validator->errors()->messages(),
			]);
		}
		$recipes = Recipe::find($id);
			if($recipes) {
				//  Image file update
				if($request->hasFile('recipe_image')){
					$oldImg = $recipes->recipe_image;
					$image = $request->file('recipe_image');
					$imageName = time().'.'.$image->getClientOriginalExtension();
					$image->storeAs('recipeImages',$imageName,'public');
					$recipes->recipe_image = 'recipeImages/'.$imageName;

					if($oldImg && Storage::disk('public')->exists($oldImg)) {
						Storage::disk('public')->delete($oldImg);
					} 
				}
				$recipes->update([
					'name' => $request->name,
					'preparation_time' => $request->preparation_time,
					'cook_time' => $request->cook_time,
					'description' => $request->description,
					'ingredients' => $request->ingredients,
					'category' => $request->category,
					'difficulty' => $request->difficulty,
					'how_to_cook' => $request->how_to_cook
				]); 
				return response()->json([
					'success' => true,
					'message' => 'recipe updated successfully'
				],200);
			} else {
				return response()->json([
					'success' => false,
					'message' => 'No such recipe found'
				],404);
				}
    } 
    // Delete  
    public function destroy($id)
    {
		$recipes = Recipe::find($id); 
		if($recipes) {
		$oldImg = $recipes->recipe_image;
		if($oldImg && Storage::disk('public')->exists($oldImg)) {
						Storage::disk('public')->delete($oldImg);
					} 
		$recipes->delete();
		return response()->json([
		'success' => true,
		'message' => 'recipe deleted successfully'
		],200);
		} else {
		return response()->json([
			'success' => false, 
			'message' => 'No such recipe found'
		],404);
		}
    }
}
