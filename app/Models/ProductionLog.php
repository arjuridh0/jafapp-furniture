<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    /**
     * The strict sequential order of production statuses.
     * Admin cannot skip stages or rollback to a previous status.
     */
    public const STATUS_SEQUENCE = [
        'order_received',
        'material_preparation',
        'in_production',
        'finishing',
        'quality_check',
        'ready_to_ship',
        'completed',
    ];

    protected $fillable = [
        'order_id',
        'status',
        'notes',
        'photo',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─── Helper Methods ──────────────────────────────────────────

    /**
     * Get the index of a given status in the sequence.
     */
    public static function getStatusIndex(string $status): int|false
    {
        return array_search($status, self::STATUS_SEQUENCE, true);
    }

    /**
     * Check if transitioning from one status to another is valid.
     * Only forward sequential transitions are allowed.
     */
    public static function isValidTransition(string $currentStatus, string $newStatus): bool
    {
        $currentIndex = self::getStatusIndex($currentStatus);
        $newIndex = self::getStatusIndex($newStatus);

        if ($currentIndex === false || $newIndex === false) {
            return false;
        }

        // Only allow moving exactly one step forward
        return $newIndex === $currentIndex + 1;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'order_received' => 'Pesanan Diterima',
            'material_preparation' => 'Persiapan Material',
            'in_production' => 'Sedang Diproduksi',
            'finishing' => 'Finishing',
            'quality_check' => 'Quality Check',
            'ready_to_ship' => 'Siap Kirim',
            'completed' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
