<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_type',
        'transaction_id',
        'status',
        'amount',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusTextAttribute(): string
    {
        return match (strtolower($this->status)) {
            'capture', 'settlement' => 'Berhasil',
            'pending' => 'Menunggu Pembayaran',
            'deny' => 'Ditolak',
            'cancel', 'expire' => 'Gagal',
            default => 'Status Tidak Diketahui',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match (strtolower($this->status)) {
            'capture', 'settlement' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'deny', 'cancel', 'expire' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
