<?php

use Livewire\Component;

new class extends Component
{
    public $images = [
        'https://via.placeholder.com/400x300/4a7c59/ffffff?text=Hotel+Exterior',
        'https://via.placeholder.com/400x300/9c8b5a/ffffff?text=Lobby',
        'https://via.placeholder.com/400x300/7d6b3d/ffffff?text=Room+1',
        'https://via.placeholder.com/400x300/5e4f2a/ffffff?text=Room+2',
        'https://via.placeholder.com/400x300/b8a77a/ffffff?text=Pool',
        'https://via.placeholder.com/400x300/d4c69a/ffffff?text=Restaurant'
    ];
};
?>

<div class="py-16 px-10 bg-gray-100 dark:bg-zinc-800">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 dark:text-zinc-100">Photo Gallery</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($images as $image)
                <div class="overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <img src="{{ $image }}" alt="Hotel Image" class="w-full h-64 object-cover hover:scale-105 transition-transform">
                </div>
            @endforeach
        </div>
    </div>
</div>
