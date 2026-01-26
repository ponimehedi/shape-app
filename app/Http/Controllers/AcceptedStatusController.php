<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Validator;
use App\Models\UserInfo;

class AcceptedStatusController extends Controller
{
    //Get Accepted status

        public function index(Request $request)
        { 
          $query = Comments::query();
          
        //   if($request->filled('state')){
		// 	$query->where('status',$request->state);
		//    } 
        
        // static way te korchi. 
        $query->where('status','accepted');

        $status = $query->get()->map(function ($item){
            return [
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

           if($status->count() > 0) {
              return response()->json([
                  'success' => true,
                  'status' => $status
              ],200);
          } else {
              return response()->json([
                  'success' => false,
                  'message' => 'No record found'
              ],404);
              }

        }
}
