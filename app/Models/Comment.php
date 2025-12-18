<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'guest_name',
        'guest_email',
        'content',
        'status',
        'ip_address',
        'user_agent',
        'approved_at',
        'approved_by',
        'likes_count',
        'replies_count',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_SPAM = 'spam';
    const STATUS_REJECTED = 'rejected';

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'approved_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeSpam($query)
    {
        return $query->where('status', self::STATUS_SPAM);
    }

    public function scopeRootComments($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithApprovedReplies($query)
    {
        return $query->with(['replies' => fn($q) => $q->approved()->with('user')]);
    }

    // Accessors
    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Anonymous';
    }

    public function getAuthorEmailAttribute(): ?string
    {
        return $this->user?->email ?? $this->guest_email;
    }

    public function getAuthorIpAttribute(): string
    {
        return $this->ip_address ?? 'Unknown';
    }

    public function getAuthorAvatarAttribute(): string
    {
        if ($this->user) {
            return $this->user->avatar_url;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->author_name) . '&background=6b7280&color=fff';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    // Methods
    public function approve(?int $approvedById = null): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => $approvedById ?? Auth::id(),
        ]);

        // Update parent's replies count
        if ($this->parent_id) {
            $this->parent->increment('replies_count');
        }

        // Update post's comments count
        $this->post->increment('comments_count');
    }

    public function reject(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    public function markAsSpam(): void
    {
        $this->update(['status' => self::STATUS_SPAM]);
    }
}

