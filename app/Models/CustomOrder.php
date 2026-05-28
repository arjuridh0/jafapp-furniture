<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomOrder extends Model
{
    use HasFactory;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CONVERTED = 'converted_to_order';

    protected $fillable = [
        'user_id',
        'order_id',
        'description',
        'dimensions',
        'material',
        'finishing',
        'color',
        'ref_images',
        'admin_notes',
        'agreed_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'ref_images' => 'array',
            'agreed_price' => 'decimal:2',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ─── Helper Methods ──────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Diajukan',
            'under_review' => 'Sedang Ditinjau',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'converted_to_order' => 'Dikonversi ke Pesanan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
