<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'name',
        'password',
        'is_admin',
        'avatar',
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * A booted() a modell "betöltésekor" egyszer lefut - itt lehet eseményekre feliratkozni.
     * A deleting esemény minden $user->delete() ELŐTT lefut, akárhonnan indul a törlés
     * (saját profil, admin egyenként, admin tömegesen), így a profilkép fájlját egy helyen töröljük.
     * Figyelem: csak betöltött modellen hívott delete() indítja el, a lekérdezésen hívott
     * (pl. User::whereIn(...)->delete()) nem - ezért a tömeges törlés is egyenként töröl.
     */
    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
        });
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
