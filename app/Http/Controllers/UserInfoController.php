<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    // get
    public function index()
    {
        $users = UserInfo::all()->map(function ($item){
            return[
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'phone' => $item->phone
            ];
          }); 

          if($users->count() > 0) {
              return response()->json([
                  'success' => true,
                  'users' => $users
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
          'name' => 'required|string|max:191',
          'email' => 'required|string',
          'phone' => 'required|string'
     ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
      } 
     $users = UserInfo::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone
     ]);
     if($users) {
        return response()->json([
            'success' => true,
            'message' => 'users created successfully'
        ],200);
     } else{
        return response()->json([
         'success' => false,
         'message'=>"something went wrong",
        ],500);
     }
    } 
    // Get BY Id 
    public function show($id)
    {
     $users = UserInfo::find($id); 

     if(!$users) {
         return response()->json([
        'success' => false,
        'message' => "No such user found",
      ],404);
      }
     
      return response()->json([
        'success' => true,
        'Users' => $users,
      ],200);  
    } 
    // Edit 
    public function edit($id)
    {
      $users = UserInfo::find($id); 

     if($users) {
      return response()->json([
        'success' => true,
        'users' => $users
      ],200);
     }else{
      return response()->json([
        'success' => false,
        'message' => 'No such found users'
      ],404);
     }
    } 
    // Update 
    public function update(Request $request,int $id)
    {
     $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:191',
        'email' => 'required|string',
        'phone' => 'required|string'
         ]); 
     if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
      }
     $users = UserInfo::find($id); 

     if($users){ 
       $users->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone
      ]); 
      return response()->json([
        'success' => true,
        'message' => 'user updated successfully'
      ],200);
     } else {
        return response()->json([
            'success' => false,
            'message' => 'No such user found'
        ],404);
        }
    } 
    // Delete 
    public function destroy($id)
    {
     $users = UserInfo::find($id); 

     if($users){ 

      $users->delete();

      return response()->json([
      'success' => true,
      'message' => 'user deleted successfully'
      ],200);
     }else {
      return response()->json([
        'success' => false, 
        'message' => 'No such user found'
      ],404);
     }
    }
}
