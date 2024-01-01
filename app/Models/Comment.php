<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'body' => 'array'  // Laravel will automatically convert json to array
    ];

    protected $fillable = [
        'body',
    ];

    // One-to-many relationship between Post (parent) and Comment (children) 
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    // One-to-many relationship between User (parent) and Comment (children)
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
