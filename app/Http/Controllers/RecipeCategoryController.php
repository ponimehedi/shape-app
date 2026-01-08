<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class RecipeCategoryController extends Controller
{   
    // get
    public function index() 
    {
        $categories = Category::all(); 

        if($categories->count()>0) 
        {
            return response()->json([
                'success' => true,
                'categories' => $categories
            ],200);
        } 
        else 
        {
            return response()->json([
                'success' => false,
                'message' => 'No record found'
            ],404);
        }
    } 
    // post 
    public function store(Request $request)
    {
     $validator = $request->validate([
          'category_name' => 'required | string | max:191',
          'category_image' => 'required | string',
          'category_description' => 'required | string | max:191'
     ]);
     $categories = Category::create([
        'category_name' => $request->category_name,
        'category_image' => $request->category_image,
        'category_description' => $request->category_description
     ]);
     if($categories) 
     {
        return response()->json([
            'success' => true,
            'message' => 'categories created successfully'
        ],200);
     } 
     else 
     {
        return response()->json([
         'success' => false,
         'message'=>"something went wrong",
        ],500);
     }
    } 
    // Get by Id 
    public function show($id) 
    {
     $categories = Category::find($id); 

     if(!$categories) {
         return response()->json([
        'success' => false,
        'message' => "No such category found",
      ],404);
      }
     
      return response()->json([
        'success' => true,
        'category' => $categories,
      ],200);   
    }
    // Edit 
    public function edit($id)
    {
     $categories = Category::find($id); 

     if($categories) 
     {
      return response()->json([
        'success' => true,
         'category' => $categories
      ],200);
     } 
     else 
     {
      return response()->json([
        'success' => false,
        'message' => 'No such found categories'
      ],404);
     }
    }
    // Update 
    public function update(Request $request,int $id)
    {
      $validator = $request->validate([
          'category_name' => 'required | string | max:191',
          'category_image' => 'required | string',
          'category_description' => 'required | string | max:191'
     ]); 
     $categories = Category::find($id);

     if($categories) 
     {
       $categories->update([
        'category_name' => $request->category_name,
        'category_image' => $request->category_image,
        'category_description' => $request->category_description
      ]); 
      return response()->json([
        'success' => true,
        'message' => 'category updated successfully'
      ],200);
     } 
     else 
     {
        return response()->json([
            'success' => false,
            'message' => 'No such category found'
        ],404);
     }
    } 
    // Delete
    public function destroy($id)
    {
      $categories = Category::find($id); 

     if($categories) 
     {
      $categories->delete();

      return response()->json([
      'success' => true,
      'message' => 'category deleted successfully'
      ],200);
     } 

     else 
     {
      return response()->json([
        'success' => false, 
        'message' => 'No such category found'
      ],404);
     }
    }
}
