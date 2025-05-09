<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'role',
        'status',
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

    const ADMIN = 'admin';
    const WRITER = 'writer';
    const PRICING = 'pricing';

    const USER_ROLE = [
        self::ADMIN, self::WRITER, self::PRICING,
    ];

    const OTHER_ROLE = [
        self::WRITER, self::PRICING,
    ];

    public function isAdmin(): bool
    {
        return $this->role == self::ADMIN;
    }

    public function isPricing(): bool
    {
        return $this->role == self::PRICING;
    }

    public function isWriter(): bool
    {
        return $this->role == self::WRITER;
    }
}
