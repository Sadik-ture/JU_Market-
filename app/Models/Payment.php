<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'listing_id',
        'amount',
        'currency',
        'transaction_id',
        'tx_ref',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // Mark as completed
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Mark listing as sold
        $this->listing->update([
            'status' => 'Sold',
            'sold_to_user_id' => $this->buyer_id,
        ]);
    }
}
