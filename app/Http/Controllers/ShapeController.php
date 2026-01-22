<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutShape;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ShapeController extends Controller
{   
    // Get
    public function index()
    {
         $shape = AboutShape::all()->map(function ($item){
            return[
            'id' => $item->id,
            'about_me' => $item->about_me,
            'image' => asset('storage/'.$item->image)
            ];
          }); 

          if($shape->count() > 0) {
              return response()->json([
                  'success' => true,
                  'shape' => $shape
              ],200);
          } else {
              return response()->json([
                  'success' => false,
                  'message' => 'No record found'
              ],404);
              }
    } 
    // Post
    public function store(Request $request) 
    {
     $validator = Validator::make($request->all(),[
            'about_me' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
        } 

      // Image file upload 
      $image = $request->file('image');
      $imageName = time().'.'.$image->getClientOriginalExtension();
		  $image->storeAs('AboutImages',$imageName,'public');

     $shape = AboutShape::create([
        'about_me' => $request->about_me,
        'image' => 'AboutImages/'.$imageName,
     ]);
     if($shape) {
            return response()->json([
                'success' => true,
                'message' => 'shapes created successfully'
            ],200);
     } else{
        return response()->json([
         'success' => false,
         'message'=>"something went wrong",
        ],500);
     }
      
    } 
    // Edit 
    public function edit($id) 
    {
    $shape = AboutShape::find($id); 

     if($shape) {
      return response()->json([
        'success' => true,
         'shape' => $shape
      ],200);
     }else{
      return response()->json([
        'success' => false,
        'message' => 'No such found shape'
      ],404);
     }
    } 
    // Update 
    public function update(Request $request,int $id) 
    {
        $validator = Validator::make($request->all(),[
            'about_me' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
        }   

     $shape = AboutShape::find($id); 

     if($shape) 
        { 
        //Image file update 
        if($request->hasFile('image')){
					$oldImg = $shape->image;
					$image = $request->file('image');
					$imageName = time().'.'.$image->getClientOriginalExtension();
					$image->storeAs('AboutImages',$imageName,'public');
					$shape->image = 'AboutImages/'.$imageName;

					if($oldImg && Storage::disk('public')->exists($oldImg)) {
						Storage::disk('public')->delete($oldImg);
					} 
				}

         $shape->update([
        'about_me' => $request->about_me
      ]); 

      return response()->json([
        'success' => true,
        'message' => 'about me updated successfully'
      ],200);
     } else {
        return response()->json([
            'success' => false,
            'message' => 'No such found'
        ],404);
        }
    }
}
