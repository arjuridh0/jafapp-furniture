<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    // ─── Status Constants ────────────────────────────────────────

    public const STATUS_PENDING_PAYMENT = 'pending_payment';
    public const STATUS_PAYMENT_CONFIRMED = 'payment_confirmed';
    public const STATUS_ORDER_RECEIVED = 'order_received';
    public const STATUS_MATERIAL_PREPARATION = 'material_preparation';
    public const STATUS_IN_PRODUCTION = 'in_production';
    public const STATUS_FINISHING = 'finishing';
    public const STATUS_QUALITY_CHECK = 'quality_check';
    public const STATUS_READY_TO_SHIP = 'ready_to_ship';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Sequential production statuses (subset of order statuses managed by admin).
     * The order here is STRICT — no skipping, no rollback.
     */
    public const PRODUCTION_STATUS_SEQUENCE = [
        'order_received',
        'material_preparation',
        'in_production',
        'finishing',
        'quality_check',
        'ready_to_ship',
        'completed',
    ];

    public const TYPE_REGULAR = 'regular';
    public const TYPE_CUSTOM = 'custom';

    protected $fillable = [
        'user_id',
        'order_number',
        'type',
        'status',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'shipping_address',
        'guest_name',
        'guest_email',
        'guest_phone',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function productionLogs(): HasMany
    {
        return $this->hasMany(ProductionLog::class);
    }

    public function customOrder(): HasOne
    {
        return $this->hasOne(CustomOrder::class);
    }

    // ─── Helper Methods ──────────────────────────────────────────

    /**
     * Get the current production status index in the sequence.
     */
    public function getCurrentProductionIndex(): int
    {
        return array_search($this->status, self::PRODUCTION_STATUS_SEQUENCE, true) ?: 0;
    }

    /**
     * Get the next valid production status, or null if already completed.
     */
    public function getNextProductionStatus(): ?string
    {
        $currentIndex = $this->getCurrentProductionIndex();
        $nextIndex = $currentIndex + 1;

        return self::PRODUCTION_STATUS_SEQUENCE[$nextIndex] ?? null;
    }

    /**
     * Check if the order is in a production-trackable state.
     */
    public function isInProduction(): bool
    {
        return in_array($this->status, self::PRODUCTION_STATUS_SEQUENCE, true);
    }

    /**
     * Check if the order has been paid.
     */
    public function isPaid(): bool
    {
        return $this->payment && $this->payment->status === 'paid';
    }

    /**
     * Get a human-readable status label in Bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'payment_confirmed' => 'Pembayaran Dikonfirmasi',
            'order_received' => 'Pesanan Diterima',
            'material_preparation' => 'Persiapan Material',
            'in_production' => 'Sedang Diproduksi',
            'finishing' => 'Finishing',
            'quality_check' => 'Quality Check',
            'ready_to_ship' => 'Siap Kirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
