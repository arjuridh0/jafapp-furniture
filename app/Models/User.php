<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'is_active',
        'is_guest',
        'activation_token',
        'activation_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
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
            'activation_token_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_guest' => 'boolean',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function customOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class);
    }

    // ─── Helper Methods ──────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isGuestAccount(): bool
    {
        return (bool) $this->is_guest;
    }

    public function isActiveAccount(): bool
    {
        return $this->is_active && $this->email_verified_at !== null;
    }

    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['admin', 'superadmin'], true);
    }
}
