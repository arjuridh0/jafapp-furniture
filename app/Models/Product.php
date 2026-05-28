<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'dimensions',
        'price',
        'stock',
        'images',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'images' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ─── Accessors ───────────────────────────────────────────────

    /**
     * Get the first image from the images array, or a default placeholder path.
     */
    public function getFirstImageAttribute(): string
    {
        $images = $this->images;

        return is_array($images) && count($images) > 0
            ? $images[0]
            : 'images/no-image.png';
    }

    // ─── Boot ────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') && ! $product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
