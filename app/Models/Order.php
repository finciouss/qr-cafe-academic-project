<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'table_number',
        'whatsapp',
        'subtotal',
        'discount',
        'total',
        'status',
        'payment_method',
        'midtrans_order_id',
        'snap_token',
        'transaction_id',
        'transaction_status',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'decimal:0',
        'discount' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;

        return $date . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
