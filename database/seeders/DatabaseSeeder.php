<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── SERVICES ──
        $services = [
            ['title' => 'Residential Construction', 'icon' => 'fas fa-home',     'description' => 'Custom homes, villas, and apartments built to your exact vision with highest quality materials and finishing.',                        'sort_order' => 1],
            ['title' => 'Commercial Construction',  'icon' => 'fas fa-building',  'description' => 'Office buildings, shopping complexes, and industrial structures constructed for longevity and performance.',                              'sort_order' => 2],
            ['title' => 'Renovation & Remodeling',  'icon' => 'fas fa-tools',     'description' => 'Breathing new life into existing structures — from simple repairs to complete overhauls.',                                               'sort_order' => 3],
            ['title' => 'Interior Design',          'icon' => 'fas fa-couch',     'description' => 'Transforming interiors into beautiful, functional spaces tailored to your taste and lifestyle.',                                          'sort_order' => 4],
            ['title' => 'Civil Works',              'icon' => 'fas fa-road',      'description' => 'Roads, drainage, retaining walls, and infrastructure works executed with technical precision and safety.',                                'sort_order' => 5],
            ['title' => 'Project Consultation',     'icon' => 'fas fa-drafting-compass', 'description' => 'Expert guidance on planning, budgeting, and executing your construction project from start to finish.',                           'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // ── PROJECTS ──
        $projects = [
            [
                'title' => 'Modern Family Villa – Butwal',
                'location' => 'Butwal, Rupandehi',
                'category' => 'residential',
                'status' => 'completed',
                'image_url' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600&q=80',
                'description' => 'A 2.5-storey modern villa designed for a joint family with seismic-safe RCC framing, natural ventilation, and premium exterior finish.',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&q=80',
                    'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=1200&q=80',
                ],
            ],
            [
                'title' => 'Office Complex – Bhairahawa',
                'location' => 'Bhairahawa, Rupandehi',
                'category' => 'commercial',
                'status' => 'ongoing',
                'image_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
                'description' => 'A multi-tenant office complex with flexible floor plates, efficient MEP planning, and modern facade systems tailored for business use.',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1200&q=80',
                    'https://images.unsplash.com/photo-1497215842964-222b430dc094?w=1200&q=80',
                ],
            ],
            [
                'title' => 'Heritage Building Restoration',
                'location' => 'Lumbini Province',
                'category' => 'renovation',
                'status' => 'completed',
                'image_url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
                'description' => 'Careful structural retrofitting and facade restoration preserving original character while upgrading safety and utilities.',
                'is_featured' => true,
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1460317442991-0ec209397118?w=1200&q=80',
                    'https://images.unsplash.com/photo-1479839672679-a46483c0e7c8?w=1200&q=80',
                ],
            ],
            [
                'title' => 'Rural Road Infrastructure',
                'location' => 'Rupandehi District',
                'category' => 'civil',
                'status' => 'planning',
                'image_url' => 'https://images.unsplash.com/photo-1565008447742-97f6f38c985c?w=600&q=80',
                'description' => 'Community road upgrade project including drainage, retaining structures, and durable surface treatment for all-weather access.',
                'is_featured' => false,
                'gallery_images' => [],
            ],
        ];
        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                $project
            );
        }

        // ── TESTIMONIALS ──
        $testimonials = [
            ['name' => 'Ram Prasad Sharma', 'location' => 'Butwal, Rupandehi',          'rating' => 5, 'message' => 'Shekhar Nirman Sewa built our dream home exactly as we envisioned. The team was professional, transparent, and delivered on time. Highly recommended to anyone looking for quality construction in Nepal.'],
            ['name' => 'Sunita Thapa',      'location' => 'Bhairahawa, Rupandehi',      'rating' => 5, 'message' => 'We hired them for our commercial building project and were blown away by the attention to detail. The project was finished within budget and the quality is top-notch. Will definitely work with them again.'],
            ['name' => 'Bikram Gurung',     'location' => 'Palpa, Lumbini Province',    'rating' => 5, 'message' => 'The renovation they did on our old building was outstanding. They respected our timeline and budget completely. I am very happy with the outcome and would recommend them without hesitation.'],
            ['name' => 'Priya Acharya',     'location' => 'Kapilvastu, Lumbini Province','rating' => 5, 'message' => 'From consultation to handover, the experience was seamless. The team is knowledgeable, courteous, and truly cares about client satisfaction. Our office space turned out better than expected!'],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

    }
}
User::updateOrCreate(
            ['email' => 'admin@sekharnirmansewa.com'],
            [
                'name'     => 'Admin User',
                'email'    => 'admin@sekharnirmansewa.com',
                'password' => Hash::make('admin123'),
            ]
        );
 
