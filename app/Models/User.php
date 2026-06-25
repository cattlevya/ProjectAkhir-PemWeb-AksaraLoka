<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_PENJUAL = 'penjual';
    const ROLE_PEMBELI = 'pembeli';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Relationships ===

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // === Helpers ===

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPenjual(): bool
    {
        return $this->role === self::ROLE_PENJUAL;
    }

    public function isPembeli(): bool
    {
        return $this->role === self::ROLE_PEMBELI;
    }

    public function hasStore(): bool
    {
        return $this->store !== null;
    }
}
