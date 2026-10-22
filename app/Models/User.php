<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Deletes the avatar file when the user is deleted.
     * Only triggered by delete() on a loaded model, not by a query delete (User::whereIn(...)->delete()).
     */
    protected static function booted(): void
    {
        static::deleting(fn (User $user) => $user->deleteAvatarFile());
    }

    /**
     * Deletes the avatar file from the public folder (if any). Does not change the avatar attribute.
     */
    public function deleteAvatarFile(): void
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

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
