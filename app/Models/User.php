<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * Field yang bisa diisi.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'phone',
        'is_active',
    ];

    /**
     * Field yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Cast untuk kolom tertentu.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Mutator: otomatis enkripsi password saat diset.
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * JWT Identifier -> pakai primary key id
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT Custom Claims
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
            'email' => $this->email,
        ];
    }
}
