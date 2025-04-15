<?php

namespace Database\Seeders;

use App\Models\FrontPage;
use Illuminate\Database\Seeder;

class FrontPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseUrl = env('APP_URL', 'http://localhost'); // Ambil URL dari .env atau gunakan default 'http://localhost'

        FrontPage::create([
            'name' => 'home',
            'slug' => 'home',
            'type' => 'page',
            'content' => [
                'hero' => [
                    'title' => 'Welcome to KopiKing',
                    'text' => 'Step into a world of delightful flavors and inviting ambiance. Experience a culinary journey like no other, crafted with passion and served with warmth.',
                    'cta-text' => 'Explore Our Menu',
                    'cta-link' => $baseUrl . '/dashboard', // URL otomatis mengikuti .env
                    'image' => 'front-images/home-hero.jpg'
                ],
                'about' => [
                    'small-title' => 'About Us',
                    'title' => 'Tradition meets innovation',
                    'text' => 'At KopiKing, we take pride in offering you a dining experience that combines culinary creativity with the heart of traditional recipes.',
                    'cta-text' => 'Learn More About Us',
                    'cta-link' => $baseUrl . '/dashboard'
                ],
                'product' => [
                    'small-title' => 'Our Signature Dishes',
                    'title' => 'Fresh, Flavorful, Crafted with Passion',
                    'cta-text' => 'View Our Full Menu',
                    'cta-link' => $baseUrl . '/dashboard'
                ],
                'contact' => [
                    'small-title' => 'Contact Us',
                    'title' => 'Get in Touch',
                    'text' => 'Feel free to reach out to us for inquiries or reservations!'
                ]
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        FrontPage::create([
            'name' => 'about',
            'slug' => 'about',
            'type' => 'page',
            'content' => [
                'hero' => [
                    'title' => 'About Us',
                    'text' => 'Established in 2024, KopiKing is built on the foundation of creating memorable experiences through food.',
                    'image' => 'front-images/about-hero.jpg'
                ],
                'mission' => [
                    'small-title' => 'Mission',
                    'title' => 'Inspire and Delight',
                    'text' => 'To bring you closer to the heart of cooking through dishes that inspire and delight.',
                ],
                'vision' => [
                    'small-title' => 'Vision',
                    'title' => 'Creating Experiences',
                    'text' => 'To be the go-to destination for food enthusiasts, creating experiences that resonate with every bite.',
                ],
                'contact' => [
                    'small-title' => 'Contact Us',
                    'title' => 'Get in Touch',
                    'text' => 'Feel free to reach out to us!',
                    'cta-text' => 'Contact Now',
                    'cta-link' => $baseUrl . '/contact'
                ]
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        FrontPage::create([
            'name' => 'menus',
            'slug' => 'menus',
            'type' => 'page',
            'content' => [
                'hero' => [
                    'title' => 'Explore Our Menu',
                    'text' => 'Discover a wide range of dishes carefully prepared using the freshest ingredients.',
                    'image' => 'front-images/menus-hero.jpg'
                ],
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        FrontPage::create([
            'name' => 'contact',
            'slug' => 'contact',
            'type' => 'page',
            'content' => [
                'hero' => [
                    'title' => 'Contact Us',
                    'text' => 'Reach out to us for any inquiries or reservations.',
                    'image' => 'front-images/contact-hero.jpg'
                ],
                'location' => [
                    'small-title' => 'Location',
                    'title' => 'Visit Us',
                    'text' => 'We’re located at Jakarta Selatan',
                    'cta-text' => 'Get Directions',
                    'cta-link' => $baseUrl . '/dashboard',
                    'latitude' => '-6.133860813147106',
                    'longitude' => '106.81449528194443',
                ],
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        FrontPage::create([
            'name' => 'logo',
            'slug' => 'logo',
            'type' => 'logo',
            'content' => [
                'company' => [
                    'logo' => 'company-images/logo.svg',
                    'name' => 'KopiKing',
                ]
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
