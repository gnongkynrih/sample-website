<?php

use App\Models\About;
use Livewire\Component;

new class extends Component
{
    public $description = '';

    public function mount(){
        $about = About::first() ;
        $this->description = $about->description ?? 'No description available';
    }
};
?>

<div class="min-h-screen bg-amber-50 dark:bg-gray-800 text-gray-800">
    <p class="text-center text-4xl font-bold py-10 text-gray-800 dark:text-yellow-400" >About Us</p>
    <p class="px-4 text-sm md:text-lg text-justify text-gray-500 dark:text-white!">
        {!! Str::limit($description, 600) !!}
    </p>
    <a href="{{ route('about') }}" class="text-blue-500 hover:underline dark:text-white">Read More</a>
</div>