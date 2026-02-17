<?php

use Livewire\Component;

new class extends Component
{
    public $services = [
        [
            'icon' => '🏊',
            'title' => 'Swimming Pool',
            'description' => 'Relax in our outdoor swimming pool with stunning views.'
        ],
        [
            'icon' => '🍽️',
            'title' => 'Restaurant',
            'description' => 'Enjoy delicious meals at our on-site restaurant.'
        ],
        [
            'icon' => '💆',
            'title' => 'Spa & Wellness',
            'description' => 'Rejuvenate with our spa treatments and wellness services.'
        ],
        [
            'icon' => '📶',
            'title' => 'Free WiFi',
            'description' => 'Stay connected with high-speed internet throughout the hotel.'
        ],
        [
            'icon' => '🅿️',
            'title' => 'Parking',
            'description' => 'Convenient parking available for all our guests.'
        ],
        [
            'icon' => '🏋️',
            'title' => 'Fitness Center',
            'description' => 'Keep fit with our fully equipped gym facilities.'
        ]
    ];
};
?>

<div class="py-16 px-10 bg-white dark:bg-zinc-900">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 dark:text-zinc-100">Our Services</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-4">{{ $service['icon'] }}</div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800 dark:text-zinc-100">{{ $service['title'] }}</h3>
                    <p class="text-gray-600 dark:text-zinc-300">{{ $service['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
