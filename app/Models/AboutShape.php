<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutShape extends Model
{
    protected $table = 'shape_about';

    protected $fillable =[
    'about_me',
    'image'
    ];
}
