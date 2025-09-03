<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookPost extends Model
{
    use HasFactory;

   protected $fillable = [
    'facebook_post_id',
    'user_id',
    'caption',
    'image_url', 
    'likes',
    'comments',
];
}
