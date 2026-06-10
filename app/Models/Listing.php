<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'category',
        'condition',
        'campus',
        'status',
        'views_count',
        'expires_at',
        'sold_to_user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'expires_at' => 'datetime',
        'views_count' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ListingPhoto::class);
    }

    public function soldTo()
    {
        return $this->belongsTo(User::class, 'sold_to_user_id');
    }

    // Scopes for filtering
    public function scopeActive($query)
    {
        return $query->where('status', 'Active')
            ->where('expires_at', '>', now());
    }

    public function scopeForCampus($query, $campus)
    {
        return $query->where('campus', $campus);
    }

    // Helper methods
    public function markAsSold($buyerId)
    {
        $this->update([
            'status' => 'Sold',
            'sold_to_user_id' => $buyerId,
        ]);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getMainPhotoAttribute()
    {
        return $this->photos->first()->photo_path ?? null;
    }

    // Add this relationship method
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function getIsFavoritedAttribute()
    {
        if (auth()->check()) {
            return auth()->user()->hasFavorited($this->id);
        }

        return false;
    }
}
