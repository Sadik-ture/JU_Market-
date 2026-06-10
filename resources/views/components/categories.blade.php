<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Browse by Category</h2>
            <p class="text-gray-600 mt-2">Find exactly what you're looking for</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $categories = [
                    ['name' => 'Electronics', 'icon' => 'fa-laptop', 'color' => 'bg-blue-100', 'text' => 'text-blue-600'],
                    ['name' => 'Textbooks', 'icon' => 'fa-book', 'color' => 'bg-green-100', 'text' => 'text-green-600'],
                    ['name' => 'Furniture', 'icon' => 'fa-couch', 'color' => 'bg-orange-100', 'text' => 'text-orange-600'],
                    ['name' => 'Clothing', 'icon' => 'fa-tshirt', 'color' => 'bg-pink-100', 'text' => 'text-pink-600'],
                    ['name' => 'Vehicles', 'icon' => 'fa-car', 'color' => 'bg-purple-100', 'text' => 'text-purple-600'],
                    ['name' => 'Other', 'icon' => 'fa-ellipsis-h', 'color' => 'bg-gray-100', 'text' => 'text-gray-600'],
                ];
            @endphp
            
            @foreach($categories as $category)
                <a href="{{ route('listings.index', ['category' => $category['name']]) }}" 
                   class="group text-center p-6 rounded-xl hover:shadow-lg transition-all hover-scale">
                    <div class="w-16 h-16 {{ $category['color'] }} rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i class="fas {{ $category['icon'] }} {{ $category['text'] }} text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ $category['name'] }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</div>