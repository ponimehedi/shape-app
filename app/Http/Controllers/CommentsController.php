<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Validator;
use App\Models\UserInfo;

class CommentsController extends Controller
{   
    // Get 
    public function index() 
    {
     $comments = Comments::all()->map(function ($item){
            return[
            'id' => $item->id,
            'user_info_id' => $item->user_info_id,
            'user_name' => $item->user->name,
            'email' => $item->user->email,
            'recipe_id' =>$item->recipe->id,
            'message' => $item->message,
            'status' => $item->status,
            'reaction' => $item->reaction
            ];
          }); 

          if($comments->count() > 0) {
              return response()->json([
                  'success' => true,
                  'comments' => $comments
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
            'name' => 'required|string|max:191',
            'email' => 'required|string',
            'phone' => 'required|string',
            'message' => 'required|string',
            'recipe_id' => 'required|integer'
        ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
      }  

      $userExist = UserInfo::where('email',$request->email)->first();
     
      if($userExist){
        $newMessage = Comments::create(
            [
                'user_info_id' => $userExist->id,
                'message' => $request->message,
                'recipe_id' =>$request->recipe_id
            ]
        );
        return response()->json([
            'success' => true,
            'message' => $newMessage
        ]);
      } 
      else {  
        $newUser = UserInfo::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        // \Log::info($newUser);
         $newMessage = Comments::create([
                    'user_info_id' => $newUser->id,
                    'message' => $request->message,
                    'recipe_id' =>$request->recipe_id,
                ]);
           return response()->json([
            'success' => true,
            'message' => $newMessage
        ]);
         }
   } 
    // Get By Id 
    public function show($id) 
    {
      $comments = Comments::find($id); 

     if(!$comments) {
         return response()->json([
        'success' => false,
        'message' => "No such comments found",
      ],404);
      }
     
      return response()->json([
        'success' => true,
        'Comments' => $comments,
      ],200);  
    } 
    // Edit 
    public function edit($id) 
    {
        $comments = Comments::find($id);

        if($comments) {
        return response()->json([
            'success' => true,
            'comments' => $comments
        ],200);
     }else{
        return response()->json([
            'success' => false,
            'message' => 'No such found comments'
        ],404);
     }
    } 
    // update 
    public function update(Request $request,int $id) 
    {
        $validator = Validator::make($request->all(),[
            'message' => 'sometimes|string',
            'status' => 'sometimes|string',
            'reaction' => 'sometimes|string'
        ]);

      if($validator->fails()) {
            return response()->json([
            'success' 	=> false,
            'message' 	=> "Validation failed",
            'errors'	=> $validator->errors()->messages(),
            ]);
      } 
       $comments = Comments::find($id); 

        if($comments){ 
        $comments->update([
            'message' => $request->message,
            'status' => $request->status,
            'reaction' => $request->reaction
        ]); 
        return response()->json([
            'success' => true,
            'message' => 'comments updated successfully'
        ],200);
     } else {
            return response()->json([
                'success' => false,
                'message' => 'No such comments found'
            ],404);
        }  
    }
    // Delete
    public function destroy($id)
    {
      $comments = Comments::find($id); 

      if($comments){ 

        $comments->delete();

        return response()->json([
        'success' => true,
        'message' => 'comments deleted successfully'
        ],200);
     }else {
        return response()->json([
            'success' => false, 
            'message' => 'No such commtnts found'
        ],404);
     }
    }
}
