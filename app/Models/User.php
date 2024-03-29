<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Multicaret\Acquaintances\Traits\Friendable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Friendable;

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
        )->where('itemable_type', (new Book())->getMorphClass());
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
        )->where('itemable_type', (new MusicAlbum())->getMorphClass());
    }
}
