<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID  = 2;
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
    ];

    //This will be used to get the pots of a single user
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //to get all the followers os a user
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    //To get all the users that the user is following
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    //To check if the login user is currently following a specific
    public function isFollowed()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
    }
}
