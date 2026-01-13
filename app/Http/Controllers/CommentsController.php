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
            'message' => 'required|string'
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
                'message' => $request->message
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
    
        if($newUser)
            {
                $newMessage = Comments::create([
                    'user_info_id' => $newUser->id,
                    'message' => $newMessage
                ]);
            }
         }
   
    }
}
