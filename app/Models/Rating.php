<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id', 'to_user_id', 'listing_id', 'payment_id',
        'rating', 'review', 'images', 'is_approved',
    ];

    protected $casts = [
        'images' => 'array',
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Get rating badge
    public function getRatingBadgeAttribute()
    {
        $badges = [
            5 => ['text' => 'Excellent', 'color' => 'green', 'icon' => 'fa-star'],
            4 => ['text' => 'Good', 'color' => 'blue', 'icon' => 'fa-star'],
            3 => ['text' => 'Average', 'color' => 'yellow', 'icon' => 'fa-star-half-alt'],
            2 => ['text' => 'Poor', 'color' => 'orange', 'icon' => 'fa-star'],
            1 => ['text' => 'Terrible', 'color' => 'red', 'icon' => 'fa-star'],
        ];

        return $badges[$this->rating] ?? $badges[5];
    }
}
