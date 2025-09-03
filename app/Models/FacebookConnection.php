<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookConnection extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'facebook_token',
        'facebook_id',
        'facebook_page_id',
        'facebook_token',
    ];
}
