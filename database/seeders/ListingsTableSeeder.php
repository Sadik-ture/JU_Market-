<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ListingsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get all user IDs
        $users = User::pluck('id')->toArray();

        // Ethiopian items for sale
        $listings = [
            // Electronics
            ['title' => 'HP Laptop Core i5', 'description' => 'HP Pavilion Core i5, 8GB RAM, 512GB SSD. Perfect for students. Like new condition.', 'price' => 35000, 'category' => 'Electronics', 'condition' => 'Like New'],
            ['title' => 'Dell XPS 15', 'description' => 'Dell XPS 15, 16GB RAM, 1TB SSD, dedicated graphics. Used for one semester.', 'price' => 55000, 'category' => 'Electronics', 'condition' => 'Good'],
            ['title' => 'iPhone 12 Pro', 'description' => 'iPhone 12 Pro, 128GB, Pacific Blue. Excellent condition with original box and charger.', 'price' => 42000, 'category' => 'Electronics', 'condition' => 'Like New'],
            ['title' => 'Samsung Galaxy S21', 'description' => 'Samsung Galaxy S21, 256GB, Phantom Black. Comes with case and screen protector.', 'price' => 38000, 'category' => 'Electronics', 'condition' => 'Good'],
            ['title' => 'Wireless Headphones', 'description' => 'Sony WH-1000XM4 noise cancelling headphones. Perfect for studying.', 'price' => 12000, 'category' => 'Electronics', 'condition' => 'Like New'],
            ['title' => 'iPad Air 4th Gen', 'description' => 'iPad Air 4th Gen, 64GB, with Apple Pencil. Great for note-taking.', 'price' => 45000, 'category' => 'Electronics', 'condition' => 'New'],

            // Textbooks
            ['title' => 'Calculus Textbook (8th Edition)', 'description' => 'James Stewart Calculus, 8th Edition. Like new, no highlights.', 'price' => 850, 'category' => 'Textbooks', 'condition' => 'Like New'],
            ['title' => 'Introduction to Algorithms', 'description' => 'CLRS Algorithms textbook. Essential for CS students.', 'price' => 1200, 'category' => 'Textbooks', 'condition' => 'Good'],
            ['title' => 'Data Structures and Algorithms', 'description' => 'Comprehensive guide to data structures. Used for Data Structures course.', 'price' => 950, 'category' => 'Textbooks', 'condition' => 'Good'],
            ['title' => 'Physics for Scientists and Engineers', 'description' => 'Serway Physics textbook, 9th Edition. Great condition.', 'price' => 1100, 'category' => 'Textbooks', 'condition' => 'Like New'],
            ['title' => 'Organic Chemistry', 'description' => 'Organic Chemistry by Clayden. Perfect for pre-med students.', 'price' => 1500, 'category' => 'Textbooks', 'condition' => 'New'],
            ['title' => 'Microeconomics', 'description' => 'Microeconomics by Pindyck, 8th Edition. No markings.', 'price' => 750, 'category' => 'Textbooks', 'condition' => 'Good'],

            // Furniture
            ['title' => 'Study Desk', 'description' => 'Wooden study desk with drawer. Perfect for dorm room.', 'price' => 2500, 'category' => 'Furniture', 'condition' => 'Good'],
            ['title' => 'Office Chair', 'description' => 'Ergonomic office chair with lumbar support.', 'price' => 3200, 'category' => 'Furniture', 'condition' => 'Like New'],
            ['title' => 'Bookshelf', 'description' => '5-tier wooden bookshelf. Holds many books.', 'price' => 1800, 'category' => 'Furniture', 'condition' => 'Good'],
            ['title' => 'Bed Frame', 'description' => 'Single bed frame with storage drawers.', 'price' => 4200, 'category' => 'Furniture', 'condition' => 'Good'],
            ['title' => 'Study Lamp', 'description' => 'LED desk lamp with adjustable brightness.', 'price' => 650, 'category' => 'Furniture', 'condition' => 'New'],
            ['title' => 'Mattress', 'description' => 'Single size memory foam mattress, gently used.', 'price' => 3500, 'category' => 'Furniture', 'condition' => 'Good'],

            // Clothing
            ['title' => 'Nike Running Shoes', 'description' => 'Nike Air Zoom, size 42. Worn only a few times.', 'price' => 3500, 'category' => 'Clothing', 'condition' => 'Like New'],
            ['title' => 'Adidas Sweatshirt', 'description' => 'Adidas Originals sweatshirt, size L. Very comfortable.', 'price' => 1800, 'category' => 'Clothing', 'condition' => 'Good'],
            ['title' => 'Traditional Ethiopian Dress', 'description' => 'Beautiful Habesha dress, size M. Handmade.', 'price' => 4500, 'category' => 'Clothing', 'condition' => 'New'],
            ['title' => 'Winter Jacket', 'description' => 'Columbia winter jacket, size L. Perfect for cold weather.', 'price' => 4200, 'category' => 'Clothing', 'condition' => 'Good'],
            ['title' => 'Backpack', 'description' => 'Jansport backpack, like new. Multiple compartments.', 'price' => 1200, 'category' => 'Clothing', 'condition' => 'Like New'],
            ['title' => 'Leather Jacket', 'description' => 'Genuine leather jacket, size XL. Very stylish.', 'price' => 5500, 'category' => 'Clothing', 'condition' => 'Good'],

            // Vehicles
            ['title' => 'Mountain Bike', 'description' => '21-speed mountain bike, recently serviced.', 'price' => 8500, 'category' => 'Vehicles', 'condition' => 'Good'],
            ['title' => 'Electric Scooter', 'description' => 'Electric scooter for campus commute. Battery lasts 25km.', 'price' => 15000, 'category' => 'Vehicles', 'condition' => 'Like New'],
            ['title' => 'Bicycle', 'description' => 'Standard bicycle with basket. Perfect for campus.', 'price' => 4500, 'category' => 'Vehicles', 'condition' => 'Good'],

            // Miscellaneous
            ['title' => 'FIFA 23 Game', 'description' => 'FIFA 23 for PlayStation 5. Like new condition.', 'price' => 1200, 'category' => 'Miscellaneous', 'condition' => 'Like New'],
            ['title' => 'Coffee Maker', 'description' => 'Electric coffee maker, perfect for early morning study sessions.', 'price' => 1800, 'category' => 'Miscellaneous', 'condition' => 'Good'],
            ['title' => 'Guitar', 'description' => 'Acoustic guitar with case. Learn to play!', 'price' => 5500, 'category' => 'Miscellaneous', 'condition' => 'Good'],
            ['title' => 'Calculator', 'description' => 'Casio scientific calculator. Perfect for engineering students.', 'price' => 850, 'category' => 'Miscellaneous', 'condition' => 'Like New'],
            ['title' => 'Board Games Set', 'description' => 'Collection of board games: Monopoly, Scrabble, Chess.', 'price' => 2500, 'category' => 'Miscellaneous', 'condition' => 'Good'],
        ];

        foreach ($listings as $index => $listingData) {
            // Random user as seller
            $sellerId = $users[array_rand($users)];

            $listing = Listing::create([
                'user_id' => $sellerId,
                'title' => $listingData['title'],
                'description' => $listingData['description'],
                'price' => $listingData['price'],
                'category' => $listingData['category'],
                'condition' => $listingData['condition'],
                'campus' => 'ju.edu.et',
                'status' => 'Active',
                'views_count' => rand(5, 200),
                'expires_at' => now()->addDays(30),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Add placeholder images (using placeholder images since we don't have real ones)
            // For real images, you'd store actual paths
            $placeholderImages = [
                'https://picsum.photos/id/20/400/300',  // Laptop
                'https://picsum.photos/id/0/400/300',   // Book
                'https://picsum.photos/id/1/400/300',   // Chair
                'https://picsum.photos/id/2/400/300',   // Clothing
                'https://picsum.photos/id/3/400/300',   // Bike
                'https://picsum.photos/id/4/400/300',   // Coffee
            ];

            // Add 1-3 photos per listing
            $numPhotos = rand(1, 3);
            for ($i = 0; $i < $numPhotos; $i++) {
                ListingPhoto::create([
                    'listing_id' => $listing->id,
                    'photo_path' => $placeholderImages[array_rand($placeholderImages)],
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
