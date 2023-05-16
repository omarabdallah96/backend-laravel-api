<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorites extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'favorite_topics',
    ];
    protected $table = 'user_favorites';

}
