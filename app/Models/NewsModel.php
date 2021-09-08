<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = "news";

    protected $fillable = [
        'id',
        'userid',
        'title',
        'description',
        'likes'
    ];
}
