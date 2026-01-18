<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments'; 

    protected $fillable = [
        'user_info_id',
        'message',
        'status',
        'reaction',
        'recipe_id'
    ];
    // relation
     public function user()
     {
        return $this->belongsTo(UserInfo::class, 'user_info_id');
     } 

     public function recipe()
     {
        return $this->belongsTo(Recipe::class,'recipe_id');
     }
    
}
