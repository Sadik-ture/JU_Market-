@extends('layouts.app-new')

@section('content')
<div class="bg-ju-offwhite min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-ju-navy/10 rounded-full mb-4">
                <i class="fas fa-plus-circle text-ju-navy text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-ju-navy-dark">Sell an Item</h1>
            <p class="text-ju-muted mt-2">List your item and reach thousands of Jimma University students</p>
        </div>
        
        <!-- Form -->
        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md border border-ju-border/50 p-8">
            @csrf
            
            <!-- Title -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-tag text-ju-gold mr-2"></i>Title *
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition"
                       placeholder="e.g., Calculus Textbook - Like New">
                @error('title') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Description -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-align-left text-ju-gold mr-2"></i>Description *
                </label>
                <textarea name="description" rows="5" required
                          class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition resize-none"
                          placeholder="Describe your item in detail...">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Price -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-money-bill-wave text-ju-gold mr-2"></i>Price (ETB) *
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ju-muted font-medium">ETB</span>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                           class="w-full pl-16 pr-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text placeholder-ju-muted/50 transition"
                           placeholder="0.00">
                </div>
                @error('price') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Category & Condition -->
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                        <i class="fas fa-list text-ju-gold mr-2"></i>Category *
                    </label>
                    <select name="category" required class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text transition">
                        <option value="">Select Category</option>
                        <option value="Electronics">📱 Electronics</option>
                        <option value="Textbooks">📚 Textbooks</option>
                        <option value="Furniture">🪑 Furniture</option>
                        <option value="Clothing">👕 Clothing</option>
                        <option value="Vehicles">🚗 Vehicles</option>
                        <option value="Miscellaneous">🎁 Miscellaneous</option>
                    </select>
                    @error('category') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                        <i class="fas fa-clipboard-list text-ju-gold mr-2"></i>Condition *
                    </label>
                    <select name="condition" required class="w-full px-4 py-3 bg-ju-offwhite border border-ju-border rounded-xl focus:border-ju-navy focus:ring-2 focus:ring-ju-navy/20 text-ju-text transition">
                        <option value="">Select Condition</option>
                        <option value="New">✨ Brand New</option>
                        <option value="Like New">👍 Like New</option>
                        <option value="Good">✅ Good</option>
                        <option value="Fair">⚠️ Fair</option>
                    </select>
                    @error('condition') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <!-- Photos Upload -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-ju-navy-dark mb-2">
                    <i class="fas fa-images text-ju-gold mr-2"></i>Photos (Max 5, 5MB each) *
                </label>
                <div class="border-2 border-dashed border-ju-border rounded-xl p-8 text-center hover:border-ju-navy transition group bg-ju-offwhite">
                    <input type="file" name="photos[]" multiple accept="image/*" required id="photos" class="hidden">
                    <label for="photos" class="cursor-pointer block">
                        <i class="fas fa-cloud-upload-alt text-5xl text-ju-muted group-hover:text-ju-navy transition mb-3 block"></i>
                        <p class="text-ju-muted group-hover:text-ju-navy transition">Click or drag images to upload</p>
                        <p class="text-xs text-ju-muted/60 mt-2">PNG, JPG, GIF up to 5MB each</p>
                    </label>
                </div>
                <div id="imagePreview" class="flex gap-2 mt-3 flex-wrap"></div>
                @error('photos.*') <p class="mt-1 text-sm text-ju-red">{{ $message }}</p> @enderror
            </div>
            
            <!-- Tips Box -->
            <div class="bg-ju-surface rounded-xl p-4 mb-6 border border-ju-border">
                <div class="flex items-start gap-3">
                    <i class="fas fa-lightbulb text-ju-gold text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-ju-navy-dark text-sm">Tips for a successful listing:</h4>
                        <ul class="text-xs text-ju-muted mt-1 space-y-1">
                            <li>• Take clear, well-lit photos of your item</li>
                            <li>• Be honest about the condition</li>
                            <li>• Set a reasonable price</li>
                            <li>• Respond quickly to interested buyers</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-ju-navy hover:bg-ju-navy-dark text-white py-3 rounded-xl font-semibold text-lg transition flex items-center justify-center gap-2 shadow-sm">
                <i class="fas fa-check-circle"></i> Post Listing
            </button>
        </form>
    </div>
</div>

<script>
    // Image Preview
    const photosInput = document.getElementById('photos');
    const previewContainer = document.getElementById('imagePreview');
    
    if (photosInput) {
        photosInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            const files = Array.from(this.files);
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 object-cover rounded-lg border border-ju-border shadow-sm';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }
</script>

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
    .hover\:border-ju-navy:hover { border-color: #003087; }
    .group:hover .group-hover\:text-ju-navy { color: #003087; }
</style>
@endsection