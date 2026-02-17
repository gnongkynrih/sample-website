<?php

use Livewire\Component;

new class extends Component
{
    public $testimonials = [
        [
            'name' => 'John Doe',
            'review' => 'Amazing stay! The rooms were clean and the staff was friendly.',
            'rating' => 5,
            'image' => 'https://via.placeholder.com/100'
        ],
        [
            'name' => 'Jane Smith',
            'review' => 'Perfect location and great amenities. Will definitely come back!',
            'rating' => 5,
            'image' => 'https://via.placeholder.com/100'
        ],
        [
            'name' => 'Mike Johnson',
            'review' => 'Excellent service and comfortable beds. Highly recommended.',
            'rating' => 4,
            'image' => 'https://via.placeholder.com/100'
        ]
    ];
};
?>

<div class="py-16 px-10 bg-gray-100 dark:bg-zinc-800">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 dark:text-zinc-100">What Our Guests Say</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-zinc-100">{{ $testimonial['name'] }}</h3>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-zinc-300 italic">"{{ $testimonial['review'] }}"</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
