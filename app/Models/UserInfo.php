<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'users_info';

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];
    // relation
    public function comments()
    {
        return $this->hasMany(Comments::class, 'user_info_id');
    }

}
