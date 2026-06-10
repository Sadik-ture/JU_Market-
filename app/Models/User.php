<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\IDVerificationNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'student_id',           // ← ADD THIS
        'email',
        'university_domain',    // ← ADD THIS
        'department',           // ← ADD THIS
        'graduation_year',      // ← ADD THIS
        'profile_photo',
        'bio',
        'is_verified_seller',
        'rating_avg',
        'last_seen_at',
        'is_suspended',
        'password',
        'id_photo_path',
        'id_verification_status',
        'id_verification_notes',
        'id_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Add this relationship method
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteListings()
    {
        return $this->belongsToMany(Listing::class, 'favorites')->withTimestamps();
    }

    public function hasFavorited($listingId)
    {
        return $this->favoriteListings()->where('listing_id', $listingId)->exists();
    }

    // Conversations where user is buyer
    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    // Conversations where user is seller
    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    // All conversations
    public function conversations()
    {
        return Conversation::where('buyer_id', $this->id)
            ->orWhere('seller_id', $this->id);
    }

    // Unread messages count
    public function unreadMessagesCount()
    {
        return Message::where('receiver_id', $this->id)
            ->where('is_read', false)
            ->count();
    }

    // Sent messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Received messages
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Add this inside the User class

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function paymentsAsSeller()
    {
        return $this->hasMany(Payment::class, 'seller_id');
    }

    public function paymentsAsBuyer()
    {
        return $this->hasMany(Payment::class, 'buyer_id');
    }

    // Relationships
    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'from_user_id');
    }

    public function receivedRatings()
    {
        return $this->hasMany(Rating::class, 'to_user_id');
    }

    public function averageRating()
    {
        return $this->receivedRatings()->where('is_approved', true)->avg('rating') ?? 0;
    }

    public function ratingCount()
    {
        return $this->receivedRatings()->where('is_approved', true)->count();
    }

    // Get rating stars HTML
    public function getRatingStarsAttribute()
    {
        $avg = round($this->averageRating());
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $avg) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $stars .= '<i class="far fa-star text-gray-400"></i>';
            }
        }

        return $stars;
    }

    // Add accessors
    public function getIdVerificationStatusBadgeAttribute()
    {
        return match ($this->id_verification_status) {
            'approved' => '<span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs"><i class="fas fa-check-circle"></i> ID Verified</span>',
            'pending' => '<span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs"><i class="fas fa-clock"></i> ID Pending</span>',
            'rejected' => '<span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs"><i class="fas fa-times-circle"></i> ID Rejected</span>',
            default => '<span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full text-xs"><i class="fas fa-id-card"></i> Not Submitted</span>',
        };
    }

    public function isIdVerified()
    {
        return $this->id_verification_status === 'approved';
    }

    // Show pending ID verifications
    // Show pending ID verifications
    public function pendingVerifications()
    {
        $users = User::where('id_verification_status', 'pending')
            ->whereNotNull('id_photo_path')
            ->latest()
            ->paginate(20);

        return view('admin.pending-ids', compact('users'));
    }

    // Approve ID verification
    public function approveId(User $user)
    {
        $user->update([
            'id_verification_status' => 'approved',
            'id_verified_at' => now(),
            'is_verified_seller' => true,
        ]);

        // ========== SEND EMAIL ==========
        try {
            Mail::to($user->email)->send(new IDVerificationNotification($user, 'approved'));
            \Log::info('Approval email sent to: '.$user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: '.$e->getMessage());
        }
        // ================================

        return back()->with('success', 'Student ID approved. '.$user->name.' is now verified.');
    }

    // Reject ID verification
    public function rejectId(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user->update([
            'id_verification_status' => 'rejected',
            'id_verification_notes' => $request->reason,
        ]);

        // ========== SEND EMAIL ==========
        try {
            Mail::to($user->email)->send(new IDVerificationNotification($user, 'rejected', $request->reason));
            \Log::info('Rejection email sent to: '.$user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: '.$e->getMessage());
        }
        // ================================

        return back()->with('success', 'ID verification rejected. User notified.');
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            return Storage::url($this->profile_photo);
        }

        // Return a default avatar with user's initial
        return 'https://ui-avatars.com/api/?background=003087&color=fff&rounded=true&size=120&name='.urlencode($this->name);
    }
}
