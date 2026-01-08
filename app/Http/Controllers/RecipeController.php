<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{  
    // Get
    public function index() 
    {
        $recipes = Recipe::all();

        if($recipes->count()>0) 
        {
            return response()->json([
                'status' => 200,
                 'recipes' => $recipes
            ],200);
        } 
        else 
        {
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
        }
    } 
    // Post 
    public function store(Request $request) 
    {
      $validator = $request->validate([
        'name' => 'required | string | max:191',
        'recipe_image' => 'required | string',
        'preparation_time' => 'required',
        'cook_time' => 'required',
        'description' => 'required | string | max:191',
        'ingredients' => 'required | string | max:191',
        'category' => 'required | string | max:191',
        'difficulty' => 'required |string | max:191'
      ]); 

       $recipes = Recipe::create([
        'name' => $request->name,
        'recipe_image' => $request->recipe_image,
        'preparation_time' => $request->preparation_time,
        'cook_time' => $request->cook_time,
        'description' => $request->description,
        'ingredients' => $request->ingredients,
        'category' => $request->category,
        'difficulty' => $request->difficulty
       ]);
     //$recipes = Recipe::create($request->all());
       if($recipes) 
       {
        return response()->json([
             'status'=>200,
             'message'=>"recipe created successfully",
        ],200);
       } 
       else 
       {
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
        'recipes' => $recipes,
      ],200);    
    } 
    // Edit 
    public function edit($id) 
    {
     $recipes = Recipe::find($id); 

     if($recipes) 
     {
      return response()->json([
        'success' => true,
         'recipe' => $recipes
      ],200);
     } 
     else 
     {
      return response()->json([
        'success' => false,
        'message' => 'No such found recipe'
      ],404);
     }
    } 
    // Update 
    public function update(Request $request,int $id) 
    {
     $validator = $request->validate([
        'name' => 'required | string | max:191',
        'recipe_image' => 'required | string',
        'preparation_time' => 'required',
        'cook_time' => 'required',
        'description' => 'required | string | max:191',
        'ingredients' => 'required | string | max:191',
        'category' => 'required | string | max:191',
        'difficulty' => 'required |string | max:191'
     ]);
     $recipes = Recipe::find($id);

     if($recipes) 
     {
      $recipes->update([
        'name' => $request->name,
        'recipe_image' => $request->recipe_image,
        'preparation_time' => $request->preparation_time,
        'cook_time' => $request->cook_time,
        'description' => $request->description,
        'ingredients' => $request->ingredients,
        'category' => $request->category,
        'difficulty' => $request->difficulty
      ]); 
      return response()->json([
        'success' => true,
         'message' => 'recipe updated successfully'
      ],200);
     } 
     else 
     {
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

     if($recipes) 
     {
      $recipes->delete();

      return response()->json([
      'success' => true,
      'message' => 'recipe deleted successfully'
      ],200);
     } 

     else 
     {
      return response()->json([
        'success' => false, 
        'message' => 'No such recipe found'
      ],404);
     }
    }
}
