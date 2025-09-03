<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstgramConnection extends Model
{
    use HasFactory;
    
    protected $table = 'instagram_connections';
    
    protected $fillable = [
        'user_id',
        'instagram_id',
    ];
}
