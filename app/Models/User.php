<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable; // TwoFactorAuthenticatable;  Note! If 2fa is enabled/used, User model must have the TwoFactorAuthenticatable trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // One-to-many relationship between User (parent) and Comment (children)
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    // Many-to-many relationship between Post and User using 'post_user' pivot table
    public function posts() {
        return $this->belongsToMany(Post::class, 'post_user', 'user_id', 'post_id');
    }
}
