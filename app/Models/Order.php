<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Status constants
    const STATUS_MENUNGGU = 'menunggu_pembayaran';
    const STATUS_DIBAYAR = 'dibayar';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_DIKIRIM = 'dikirim';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Status labels untuk tampilan
    const STATUS_LABELS = [
        self::STATUS_MENUNGGU => 'Menunggu Konfirmasi',
        self::STATUS_DIBAYAR => 'Dibayar',
        self::STATUS_DIPROSES => 'Diproses',
        self::STATUS_DIKIRIM => 'Dikirim',
        self::STATUS_SELESAI => 'Selesai',
        self::STATUS_DIBATALKAN => 'Dibatalkan',
    ];

    // Status colors untuk badge UI
    const STATUS_COLORS = [
        self::STATUS_MENUNGGU => 'yellow',
        self::STATUS_DIBAYAR => 'blue',
        self::STATUS_DIPROSES => 'indigo',
        self::STATUS_DIKIRIM => 'purple',
        self::STATUS_SELESAI => 'green',
        self::STATUS_DIBATALKAN => 'red',
    ];

    // State machine: valid transitions
    const VALID_TRANSITIONS = [
        self::STATUS_MENUNGGU => [self::STATUS_DIBAYAR, self::STATUS_DIBATALKAN],
        self::STATUS_DIBAYAR => [self::STATUS_DIPROSES, self::STATUS_DIBATALKAN],
        self::STATUS_DIPROSES => [self::STATUS_DIKIRIM],
        self::STATUS_DIKIRIM => [self::STATUS_SELESAI],
        self::STATUS_SELESAI => [],
        self::STATUS_DIBATALKAN => [],
    ];

    protected $fillable = [
        'order_code',
        'buyer_id',
        'total_amount',
        'shipping_address',
        'payment_proof',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    // === Relationships ===

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // === Accessors ===

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // === Helpers ===

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::VALID_TRANSITIONS[$this->status] ?? [];
        return in_array($newStatus, $allowed);
    }

    public function getValidTransitions(): array
    {
        return self::VALID_TRANSITIONS[$this->status] ?? [];
    }

    /**
     * Ambil semua store yang terlibat dalam order ini
     */
    public function getInvolvedStoreIds(): array
    {
        return $this->items()->distinct()->pluck('store_id')->toArray();
    }
}
