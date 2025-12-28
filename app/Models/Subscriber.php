<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'status',
        'token',
        'subscribed_at',
        'unsubscribed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            $subscriber->token = Str::random(64);
            $subscriber->subscribed_at = now();
        });
    }

    /**
     * Scope for active subscribers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for pending subscribers
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Check if subscriber is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Unsubscribe the user
     */
    public function unsubscribe(): void
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }

    /**
     * Resubscribe the user
     */
    public function resubscribe(): void
    {
        $this->update([
            'status' => 'active',
            'unsubscribed_at' => null,
            'subscribed_at' => now(),
        ]);
    }

    /**
     * Get unsubscribe URL
     */
    public function getUnsubscribeUrlAttribute(): string
    {
        return route('subscriber.unsubscribe', $this->token);
    }
}
