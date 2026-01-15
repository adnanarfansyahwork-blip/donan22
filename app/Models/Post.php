<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    /**
     * Status constants
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_SCHEDULED = 'scheduled';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'user_id',
        'category_id',
        'post_type_id',
        'status',
        'published_at',
        'scheduled_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'is_indexable',
        'views_count',
        'downloads_count',
        'comments_count',
        'is_featured',
        'is_trending',
        'allow_comments',
        'show_toc',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'is_indexable' => 'boolean',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'allow_comments' => 'boolean',
        'show_toc' => 'boolean',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
        'comments_count' => 'integer',
    ];

    /**
     * The attributes that should have default values.
     */
    protected $attributes = [
        'status' => self::STATUS_DRAFT,
        'is_indexable' => true,
        'is_featured' => false,
        'is_trending' => false,
        'allow_comments' => true,
        'show_toc' => false,
        'views_count' => 0,
        'downloads_count' => 0,
        'comments_count' => 0,
    ];

    /**
     * Get the slug options.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     * Use ID for admin routes
     */
    public function getRouteKeyName(): string
    {
        // Check if we're in admin routes
        if (request()->is('admin/*')) {
            return 'id';
        }
        return 'slug';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the author (user) of the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'user_id')->withDefault([
            'name' => 'Unknown Author',
        ]);
    }

    /**
     * Alias for user relationship.
     */
    public function author(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Get the category of the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
        ]);
    }

    /**
     * Get the post type.
     */
    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class)->withDefault([
            'name' => 'Article',
            'slug' => 'article',
        ]);
    }

    /**
     * Get the software detail for the post.
     */
    public function softwareDetail(): HasOne
    {
        return $this->hasOne(SoftwareDetail::class);
    }

    /**
     * Get the download links for the post.
     */
    public function downloadLinks(): HasMany
    {
        return $this->hasMany(DownloadLink::class)->orderBy('sort_order');
    }

    /**
     * Get the comments for the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the approved comments for the post.
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the tags for the post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft posts.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    /**
     * Scope a query to only include scheduled posts.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED)
            ->where('scheduled_at', '>', now());
    }

    /**
     * Scope a query to only include featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include trending posts.
     */
    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    /**
     * Scope a query to filter by post type slug.
     */
    public function scopeOfType($query, string $typeSlug)
    {
        return $query->whereHas('postType', function ($q) use ($typeSlug) {
            $q->where('slug', $typeSlug);
        });
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopePopular($query)
    {
        return $query->orderByDesc('views_count');
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('published_at');
    }

    /**
     * Scope a query to search by title and content.
     */
    public function scopeSearch($query, string $term)
    {
        $keywords = array_filter(explode(' ', $term));
        
        return $query->where(function ($q) use ($term, $keywords) {
            // Search for exact phrase first (highest priority)
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('meta_keywords', 'like', "%{$term}%")
                ->orWhere('meta_description', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%")
                // Search in tags
                ->orWhereHas('tags', function ($tagQuery) use ($term) {
                    $tagQuery->where('name', 'like', "%{$term}%");
                })
                // Search in category
                ->orWhereHas('category', function ($catQuery) use ($term) {
                    $catQuery->where('name', 'like', "%{$term}%");
                })
                // Search in software details
                ->orWhereHas('softwareDetail', function ($softQuery) use ($term) {
                    $softQuery->where('version', 'like', "%{$term}%")
                        ->orWhere('developer', 'like', "%{$term}%")
                        ->orWhere('os_requirements', 'like', "%{$term}%");
                });
            
            // Also search for individual keywords
            foreach ($keywords as $keyword) {
                $q->orWhere('title', 'like', "%{$keyword}%")
                    ->orWhere('excerpt', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            }
        })->orderByRaw(
            "CASE 
                WHEN LOWER(title) LIKE LOWER(?) THEN 1
                WHEN LOWER(excerpt) LIKE LOWER(?) THEN 2
                WHEN LOWER(meta_keywords) LIKE LOWER(?) THEN 3
                ELSE 4
            END, published_at DESC",
            ["%{$term}%", "%{$term}%", "%{$term}%"]
        );
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to software posts.
     */
    public function scopeSoftware($query)
    {
        return $query->ofType('software');
    }

    /**
     * Scope a query to mobile apps posts.
     */
    public function scopeMobileApps($query)
    {
        return $query->ofType('mobile-apps');
    }

    /**
     * Scope a query to tutorials posts.
     */
    public function scopeTutorials($query)
    {
        return $query->ofType('tutorials');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the post URL.
     */
    public function getUrlAttribute(): string
    {
        return route('posts.show', $this->slug);
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if (!empty($this->featured_image)) {
            // Check if it's already a full URL
            if (str_starts_with($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            
            // Remove 'posts/' prefix if exists (old storage format)
            $filename = str_starts_with($this->featured_image, 'posts/')
                ? substr($this->featured_image, 6)
                : $this->featured_image;
            
            // Check if file exists in base_path uploads/posts (correct location)
            $filePath = base_path('uploads/posts/' . $filename);
            if (file_exists($filePath)) {
                return asset('uploads/posts/' . $filename);
            }
        }
        
        return $this->getPlaceholderImage();
    }

    /**
     * Get placeholder image.
     */
    public function getPlaceholderImage(): string
    {
        
        return asset('images/no-image.svg');
    }

    /**
     * Get the meta title, fallback to post title.
     */
    public function getMetaTitleDisplayAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    /**
     * Get the meta description, fallback to excerpt.
     */
    public function getMetaDescriptionDisplayAttribute(): ?string
    {
        return $this->meta_description ?: $this->excerpt;
    }

    /**
     * Get estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int) ceil($wordCount / 200));
    }

    /**
     * Check if post is currently published.
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === self::STATUS_PUBLISHED 
            && $this->published_at 
            && $this->published_at <= now();
    }

    /**
     * Check if post is software type.
     */
    public function getIsSoftwareAttribute(): bool
    {
        return $this->postType?->slug === 'software';
    }

    /**
     * Check if post is mobile app type.
     */
    public function getIsMobileAppAttribute(): bool
    {
        return $this->postType?->slug === 'mobile-apps';
    }

    /**
     * Check if post has software details.
     */
    public function getHasSoftwareDetailAttribute(): bool
    {
        return in_array($this->postType?->slug, ['software', 'mobile-apps']);
    }

    /**
     * Get formatted published date.
     */
    public function getPublishedDateAttribute(): string
    {
        return $this->published_at?->format('M d, Y') ?? 'Not published';
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'bg-green-100 text-green-700',
            self::STATUS_DRAFT => 'bg-yellow-100 text-yellow-700',
            self::STATUS_SCHEDULED => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SCHEDULED => 'Scheduled',
            default => ucfirst($this->status),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Increment view count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Increment download count.
     */
    public function incrementDownloads(): void
    {
        $this->increment('downloads_count');
    }

    /**
     * Get primary download link.
     */
    public function getPrimaryDownloadLink(): ?DownloadLink
    {
        return $this->downloadLinks()
            ->where('is_primary', true)
            ->where('is_active', true)
            ->first() ?? $this->downloadLinks()->where('is_active', true)->first();
    }

    /**
     * Publish the post.
     */
    public function publish(): void
    {
        $this->update([
            'status' => self::STATUS_PUBLISHED,
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    /**
     * Unpublish the post (set to draft).
     */
    public function unpublish(): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
        ]);
    }

    /**
     * Schedule the post.
     */
    public function schedule(\DateTime $scheduledAt): void
    {
        $this->update([
            'status' => self::STATUS_SCHEDULED,
            'scheduled_at' => $scheduledAt,
        ]);
    }

    /**
     * Get related posts.
     */
    public function getRelatedPosts(int $limit = 4)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('category_id', $this->category_id)
                    ->orWhere('post_type_id', $this->post_type_id);
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get the previous post (older/chronologically before).
     */
    public function getPreviousPost(): ?self
    {
        return static::published()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    /**
     * Get the next post (newer/chronologically after).
     */
    public function getNextPost(): ?self
    {
        return static::published()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    /**
     * Get more related posts for better internal linking (SEO).
     * This includes posts from same category, same type, or with similar tags.
     */
    public function getMoreRelatedPosts(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        $tagIds = $this->tags ? $this->tags->pluck('id')->toArray() : [];
        
        return static::published()
            ->where('id', '!=', $this->id)
            ->where(function ($query) use ($tagIds) {
                // Same category
                $query->where('category_id', $this->category_id)
                    // Or same post type
                    ->orWhere('post_type_id', $this->post_type_id);
                
                // Or has same tags
                if (!empty($tagIds)) {
                    $query->orWhereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->with(['category'])
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Generate JSON-LD Schema for Article (SEO).
     */
    public function getSchemaMarkup(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->meta_title ?? $this->title,
            'description' => $this->meta_description ?? $this->excerpt,
            'image' => url($this->featured_image_url),
            'datePublished' => $this->published_at?->toIso8601String() ?? now()->toIso8601String(),
            'dateModified' => $this->updated_at?->toIso8601String() ?? $this->published_at?->toIso8601String() ?? now()->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Donan22',
                'url' => url('/'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Donan22',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => url('assets/images/logo.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url(route('posts.show', $this->slug, false)),
            ],
            'articleSection' => $this->category?->name ?? 'Software',
            'keywords' => $this->meta_keywords,
        ];
    }

    /**
     * Generate Breadcrumb Schema (SEO).
     */
    public function getBreadcrumbSchema(): array
    {
        $items = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
        ];

        if ($this->category) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $this->category->name,
                'item' => url(route('categories.show', $this->category->slug, false)),
            ];
            
            $items[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $this->title,
                'item' => url(route('posts.show', $this->slug, false)),
            ];
        } else {
            $items[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $this->title,
                'item' => url(route('posts.show', $this->slug, false)),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /**
     * Sync tags by IDs.
     */
    public function syncTags(array $tagIds): void
    {
        $this->tags()->sync($tagIds);
    }

    /**
     * Update or create software detail.
     */
    public function saveSoftwareDetail(array $data): ?SoftwareDetail
    {
        if (empty(array_filter($data))) {
            return null;
        }

        return $this->softwareDetail()->updateOrCreate(
            ['post_id' => $this->id],
            $data
        );
    }

    /**
     * Sync download links.
     */
    public function syncDownloadLinks(array $links): void
    {
        // Delete existing links
        $this->downloadLinks()->delete();

        // Create new links
        foreach ($links as $index => $link) {
            if (!empty($link['url'])) {
                $this->downloadLinks()->create([
                    'name' => $link['name'] ?? 'Download',
                    'url' => $link['url'],
                    'provider' => $link['provider'] ?? null,
                    'file_size' => $link['file_size'] ?? null,
                    'password' => $link['password'] ?? null,
                    'is_primary' => $index === 0,
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    /**
     * Get available statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_SCHEDULED => 'Scheduled',
        ];
    }
}
