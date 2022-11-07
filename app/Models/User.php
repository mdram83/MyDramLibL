<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
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

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function books()
    {
        return $this->hasManyThrough(
            Book::class,
            Item::class,
            'user_id',
            'id',
            'id',
            'itemable_id'
        )->where('itemable_type', array_keys(Relation::morphMap(), Book::class)[0]);
    }

    public function musicAlbums()
    {
        return $this->hasManyThrough(
            MusicAlbum::class,
            Item::class,
            'user_id',
            'id',
            'id',
            'itemable_id'
        )->where('itemable_type', array_keys(Relation::morphMap(), MusicAlbum::class)[0]);
    }
}
