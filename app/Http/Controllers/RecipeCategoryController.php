<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeCategoryController extends Controller
{   
      // get
      public function index() 
      {
          $categories = Category::all()->map(function ($item){
            return[
            'id' => $item->id,
            'category_name' => $item->category_name,
            'category_image' => asset('storage/'.$item->category_image),
            'category_description' => $item->category_description
            ];
          }); 

          if($categories->count() > 0) {
              return response()->json([
                  'success' => true,
                  'categories' => $categories
              ],200);
          } else {
              return response()->json([
                  'success' => false,
                  'message' => 'No record found'
              ],404);
              }
      } 
    // post 
    public function store(Request $request)
    {
     $validator = Validator::make($request->all(),[
          'category_name' => 'required|string|max:191',
          'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'category_description' => 'required|string'
     ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
      } 
    // Img file upload
		$image = $request->file('category_image');
		$imageName = time().'.'.$image->getClientOriginalExtension();
		$image->storeAs('categoryImages',$imageName,'public');

     $categories = Category::create([
        'category_name' => $request->category_name,
        'category_image' => 'categoryImages/'.$imageName,
        'category_description' => $request->category_description
     ]);
     if($categories) {
        return response()->json([
            'success' => true,
            'message' => 'categories created successfully'
        ],200);
     } else{
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

     if($categories) {
      return response()->json([
        'success' => true,
         'category' => $categories
      ],200);
     }else{
      return response()->json([
        'success' => false,
        'message' => 'No such found categories'
      ],404);
     }
    }
    // Update 
    public function update(Request $request,int $id)
    { 
      $validator = Validator::make($request->all(),[
          'category_name' => 'sometimes|string|max:191',
          'category_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'category_description' => 'sometimes|string'
     ]); 
     if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
      }
     $categories = Category::find($id);

     if($categories){ 
        //  Image file update
				if($request->hasFile('category_image')){
					$oldImg = $categories->category_image;
					$image = $request->file('category_image');
					$imageName = time().'.'.$image->getClientOriginalExtension();
					$image->storeAs('categoryImages',$imageName,'public');
					$categories->category_image = 'categoryImages/'.$imageName;

					if($oldImg && Storage::disk('public')->exists($oldImg)) {
						Storage::disk('public')->delete($oldImg);
					} 
				}
       $categories->update([
        'category_name' => $request->category_name,
        'category_description' => $request->category_description
      ]); 
      return response()->json([
        'success' => true,
        'message' => 'category updated successfully'
      ],200);
     } else {
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

     if($categories){ 
      $oldImg = $categories->category_image;
      if($oldImg && Storage::disk('public')->exists($oldImg)) {
						Storage::disk('public')->delete($oldImg);
					} 
      $categories->delete();

      return response()->json([
      'success' => true,
      'message' => 'category deleted successfully'
      ],200);
     }else {
      return response()->json([
        'success' => false, 
        'message' => 'No such category found'
      ],404);
     }
    }
}
