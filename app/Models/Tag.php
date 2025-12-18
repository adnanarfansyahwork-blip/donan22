<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->withCount('posts')
            ->orderByDesc('posts_count');
    }

    // Accessors
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->published()->count();
    }
}
