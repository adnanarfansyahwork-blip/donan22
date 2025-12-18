<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DownloadLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',
        'url',
        'monetized_url',
        'provider',
        'file_size',
        'file_format',
        'password',
        'is_primary',
        'is_active',
        'is_monetized',
        'download_count',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'is_monetized' => 'boolean',
    ];

    // Common providers
    const PROVIDER_DIRECT = 'Direct';
    const PROVIDER_GOOGLE_DRIVE = 'Google Drive';
    const PROVIDER_MEDIAFIRE = 'MediaFire';
    const PROVIDER_MEGA = 'MEGA';
    const PROVIDER_DROPBOX = 'Dropbox';
    const PROVIDER_ONEDRIVE = 'OneDrive';
    const PROVIDER_GITHUB = 'GitHub';
    const PROVIDER_SOURCEFORGE = 'SourceForge';

    public static function providers(): array
    {
        return [
            self::PROVIDER_DIRECT => 'Direct Download',
            self::PROVIDER_GOOGLE_DRIVE => 'Google Drive',
            self::PROVIDER_MEDIAFIRE => 'MediaFire',
            self::PROVIDER_MEGA => 'MEGA',
            self::PROVIDER_DROPBOX => 'Dropbox',
            self::PROVIDER_ONEDRIVE => 'OneDrive',
            self::PROVIDER_GITHUB => 'GitHub',
            self::PROVIDER_SOURCEFORGE => 'SourceForge',
        ];
    }

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Accessors
    public function getDownloadUrlAttribute(): string
    {
        if ($this->is_monetized && $this->monetized_url) {
            return $this->monetized_url;
        }
        return $this->url;
    }

    public function getProviderIconAttribute(): string
    {
        $icons = [
            'Google Drive' => 'bi-google',
            'MediaFire' => 'bi-cloud-arrow-down',
            'MEGA' => 'bi-cloud',
            'Dropbox' => 'bi-dropbox',
            'OneDrive' => 'bi-cloud-arrow-down',
            'GitHub' => 'bi-github',
            'SourceForge' => 'bi-box-arrow-up-right',
        ];

        return $icons[$this->provider] ?? 'bi-download';
    }

    // Methods
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
        $this->post?->increment('downloads_count');
    }

    public function logDownload(?int $userId = null): void
    {
        // Simply increment download count
        $this->incrementDownloads();
    }
}
