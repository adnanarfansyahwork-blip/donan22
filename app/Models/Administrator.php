<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|Administrator where($column, $operator = null, $value = null, $boolean = 'and')
 * @method bool update(array $attributes = [], array $options = [])
 * @method bool save(array $options = [])
 */
class Administrator extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'full_name',
        'avatar',
        'role',
        'status',
        'last_login',
        'login_attempts',
        'locked_until',
        'last_login_ip',
        'last_login_at',
        'failed_login_attempts',
        'two_factor_enabled',
        'two_factor_secret',
    ];

    protected $hidden = [
        'password_hash',
        'two_factor_secret',
    ];

    /**
     * Get the name attribute (alias for full_name or username).
     */
    public function getNameAttribute(): string
    {
        return $this->full_name ?? $this->username ?? 'Unknown';
    }

    /**
     * Get the avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if (str_starts_with($this->avatar, 'http')) {
                return $this->avatar;
            }
            return url('uploads/avatars/' . $this->avatar);
        }
        
        // Default gravatar or placeholder
        $hash = md5(strtolower(trim($this->email ?? '')));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=80";
    }

    /**
     * Check if admin has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role || $this->role === 'superadmin' || $this->role === 'super_admin';
    }

    /**
     * Check if admin is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get auth password.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }
}
