<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'body' => 'array'  // Laravel will automatically convert json to array
    ];

    protected $fillable = [
        'title', 'body',
    ];

    protected $appends = [
        'title_upper_case'
    ];

    // Accessor: title_upper_case (snake format) and naming prefix 'get' and suffix 'Attribute'
    public function getTitleUpperCaseAttribute()
    {
        return strtoupper($this->title);
    }

    // Mutator: Naming prefix 'set' and suffix 'Attribute'
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    // One-to-many relationship between Post (parent) and Comment (children)
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    // Many-to-many relationship between Post and User using 'post_user' pivot table
    public function users() {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }   
}
