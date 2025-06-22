<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryLike extends Model
{
    use HasFactory;

    protected $table = 'tb_story_like';

    protected $fillable = [
        'user_id',
        'story_id',
    ];
}
