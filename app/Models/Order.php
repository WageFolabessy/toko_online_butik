<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'total_amount',
        'shipping_cost',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'awaiting_payment' => 'Menunggu Pembayaran',
            'pending' => 'Pesanan Diproses',
            'processed' => 'Siap Dikirim',
            'ready_for_pickup' => 'Siap Diambil',
            'shipped' => 'Telah Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Status Tidak Diketahui',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'awaiting_payment' => 'bg-warning text-dark',
            'pending', 'processed', 'ready_for_pickup' => 'bg-info text-dark',
            'shipped' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
