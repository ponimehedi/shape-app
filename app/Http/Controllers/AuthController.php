<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{    
     // Get All  
    public function index()
    {
      $users = User::all()->map(function ($item){
            return[
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
            'password' => $item->phone
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

    // Registration
    public function registration(Request $request) 
    {
      $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
        } 
      $user = User::where('email',$request->email)->first();

      if($user){
        return response()->json([
            'message' => 'user already exists'
        ]);
      } 

      $newUser = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]); 

      if($newUser){
         return response()->json([
            'success' => true,
            'message' => 'users created successfully'
        ],200);
      } 
      else{
        return response()->json([
         'success' => false,
         'message'=>"user created wrong",
        ],500);
      }
    } 
    // Login
    public function login(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
      if($validator->fails()) {
        return response()->json([
          'success' 	=> false,
          'message' 	=> "Validation failed",
          'errors'	=> $validator->errors()->messages(),
        ]);
        } 

        $user = User::where('email',$request->email)->first();
   
        if(!$user || !Hash::check($request->password, $user->password)) {
            // plane password,hash password
            return response()->json([
                'message'=>'authentication failed'
            ]);
        }

        //token generate

        $token = $user->createToken('API_Token')->plainTextToken;


         return response()->json([
                'message'=>'login successfull',
                'token' => $token,
                 'user' =>[
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                 ]
            ]);
      
    } 
}
