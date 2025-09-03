<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterConnection extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'twitter_id',
    'name',
    'screen_name',
    'twitter_token',
    'twitter_token_secret',
];

protected $guarded = [];
}
