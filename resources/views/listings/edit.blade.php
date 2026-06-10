@extends('layouts.app-new')

@section('content')
<div class="bg-ju-offwhite min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-ju-navy/10 rounded-full mb-4">
                <i class="fas fa-edit text-ju-navy text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-ju-navy-dark">Edit Listing</h1>
            <p class="text-ju-muted mt-2">Update your item information</p>
        </div>
        
        <!-- Form -->
        <form method="POST" action="{{ route('listings.update', $listing) }}" class="bg-white rounded-xl shadow-md border border-ju-border/50 p-8">
            @csrf 
            @method('PUT')
            
            <!-- Title -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-tag text-ju-gold mr-2"></i>Title *
                </label>
                <input type="text" name="title" value="{{ old('title', $listing->title) }}" required
                       class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition">
                @error('title') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Description -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-align-left text-ju-gold mr-2"></i>Description *
                </label>
                <textarea name="description" rows="5" required
                          class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition resize-none">{{ old('description', $listing->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Price -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-money-bill-wave text-ju-gold mr-2"></i>Price (ETB) *
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ju-muted font-medium">ETB</span>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $listing->price) }}" required
                           class="w-full pl-16 pr-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition"
                           placeholder="0.00">
                </div>
                @error('price') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Category & Condition -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                        <i class="fas fa-list text-ju-gold mr-2"></i>Category *
                    </label>
                    <select name="category" required class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text transition">
                        <option value="Electronics" {{ $listing->category == 'Electronics' ? 'selected' : '' }}>📱 Electronics</option>
                        <option value="Textbooks" {{ $listing->category == 'Textbooks' ? 'selected' : '' }}>📚 Textbooks</option>
                        <option value="Furniture" {{ $listing->category == 'Furniture' ? 'selected' : '' }}>🪑 Furniture</option>
                        <option value="Clothing" {{ $listing->category == 'Clothing' ? 'selected' : '' }}>👕 Clothing</option>
                        <option value="Vehicles" {{ $listing->category == 'Vehicles' ? 'selected' : '' }}>🚗 Vehicles</option>
                        <option value="Miscellaneous" {{ $listing->category == 'Miscellaneous' ? 'selected' : '' }}>🎁 Miscellaneous</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                        <i class="fas fa-clipboard-list text-ju-gold mr-2"></i>Condition *
                    </label>
                    <select name="condition" required class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text transition">
                        <option value="New" {{ $listing->condition == 'New' ? 'selected' : '' }}>✨ Brand New</option>
                        <option value="Like New" {{ $listing->condition == 'Like New' ? 'selected' : '' }}>👍 Like New</option>
                        <option value="Good" {{ $listing->condition == 'Good' ? 'selected' : '' }}>✅ Good</option>
                        <option value="Fair" {{ $listing->condition == 'Fair' ? 'selected' : '' }}>⚠️ Fair</option>
                    </select>
                </div>
            </div>
            
            <!-- Tips Box -->
            <div class="bg-ju-surface rounded-xl p-4 mb-6 border border-ju-border">
                <div class="flex items-start gap-3">
                    <i class="fas fa-lightbulb text-ju-gold text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-ju-navy-dark text-sm">Tips for a successful listing:</h4>
                        <ul class="text-xs text-ju-muted mt-1 space-y-1">
                            <li>• Be honest about the condition of your item</li>
                            <li>• Set a competitive price</li>
                            <li>• Respond quickly to interested buyers</li>
                            <li>• Update status once item is sold</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-ju-navy hover:bg-ju-navy-dark text-white py-3 rounded-xl font-semibold text-lg transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fas fa-save"></i> Update Listing
            </button>
        </form>
    </div>
</div>

<style>
    .bg-ju-offwhite { background-color: #f4f6fb; }
    .bg-ju-navy { background-color: #003087; }
    .bg-ju-navy-dark { background-color: #001f5e; }
    .bg-ju-gold { background-color: #C8960C; }
    .bg-ju-surface { background-color: #eef1f8; }
    .text-ju-navy { color: #003087; }
    .text-ju-navy-dark { color: #001f5e; }
    .text-ju-gold { color: #C8960C; }
    .text-ju-muted { color: #5a6480; }
    .text-ju-red { color: #c0392b; }
    .border-ju-border { border-color: #c8d2e8; }
    
    .hover\:bg-ju-navy-dark:hover { background-color: #001f5e; }
</style>
@endsection