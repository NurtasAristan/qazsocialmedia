<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function nationality() 
    {
        return $this->belongsTo(Nationality::class);
    }

    public function settlement() 
    {
        return $this->belongsTo(Settlement::class);
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function createdPeople()
    {
        return $this->hasMany(Person::class, 'created_by');
    }

    public function posts() 
    {
        return $this->hasMany(Post::class);
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked($post)
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }

    public function followingGroups() 
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function chats() 
    {
        return $this->belongsToMany(Chat::class, 'chat_user');
    }

    // Users you are following
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    // Users following you
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    // Groups you follow
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
