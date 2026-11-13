<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'name',
        'password',
        'is_admin',
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Deletes the avatar file from the public folder (if there is one).
     */
    public function deleteAvatarFile()
    {
        if ($this->avatar && file_exists(public_path($this->avatar))) {
            unlink(public_path($this->avatar));
        }
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
