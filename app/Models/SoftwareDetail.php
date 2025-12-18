<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoftwareDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'version',
        'developer',
        'developer_url',
        'license_type',
        'price',
        'currency',
        'file_size',
        'os_requirements',
        'min_requirements',
        'languages',
        'platform',
        'architecture',
        'official_website',
        'changelog_url',
        'system_requirements',
        'whats_new',
        'screenshots',
        'release_date',
        'last_updated',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'languages' => 'array',
        'screenshots' => 'array',
        'release_date' => 'date',
        'last_updated' => 'date',
    ];

    // Platform constants
    const PLATFORM_WINDOWS = 'windows';
    const PLATFORM_MACOS = 'macos';
    const PLATFORM_LINUX = 'linux';
    const PLATFORM_ANDROID = 'android';
    const PLATFORM_IOS = 'ios';
    const PLATFORM_WEB = 'web';
    const PLATFORM_CROSS = 'cross-platform';

    // License types
    const LICENSE_FREE = 'Free';
    const LICENSE_FREEMIUM = 'Freemium';
    const LICENSE_TRIAL = 'Trial';
    const LICENSE_PAID = 'Paid';
    const LICENSE_OPEN_SOURCE = 'Open Source';
    const LICENSE_FREEWARE = 'Freeware';

    public static function platforms(): array
    {
        return [
            self::PLATFORM_WINDOWS => 'Windows',
            self::PLATFORM_MACOS => 'macOS',
            self::PLATFORM_LINUX => 'Linux',
            self::PLATFORM_ANDROID => 'Android',
            self::PLATFORM_IOS => 'iOS',
            self::PLATFORM_WEB => 'Web',
            self::PLATFORM_CROSS => 'Cross-Platform',
        ];
    }

    public static function licenseTypes(): array
    {
        return [
            self::LICENSE_FREE => 'Free',
            self::LICENSE_FREEMIUM => 'Freemium',
            self::LICENSE_TRIAL => 'Trial',
            self::LICENSE_PAID => 'Paid',
            self::LICENSE_OPEN_SOURCE => 'Open Source',
            self::LICENSE_FREEWARE => 'Freeware',
        ];
    }

    // Relationships
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // Accessors
    public function getPlatformLabelAttribute(): string
    {
        return self::platforms()[$this->platform] ?? $this->platform;
    }

    public function getPriceFormattedAttribute(): string
    {
        if (!$this->price || $this->price == 0) {
            return 'Free';
        }
        
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getScreenshotUrlsAttribute(): array
    {
        if (!$this->screenshots) {
            return [];
        }
        
        return array_map(fn($s) => asset('assets/uploads/' . $s), $this->screenshots);
    }

    public function getIsFreeAttribute(): bool
    {
        return in_array($this->license_type, [self::LICENSE_FREE, self::LICENSE_FREEWARE, self::LICENSE_OPEN_SOURCE])
            || (!$this->price || $this->price == 0);
    }
}
