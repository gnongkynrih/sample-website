<?php

use Livewire\Component;
use App\Models\Hero;

new class extends Component
{
    public $heroSections = [];
    
    public function mount(){
        $this->heroSections = Hero::all();
    }
};
?>

<div>
    <div class="swiper mySwiper" style="height: 25em">
        <div class="swiper-wrapper h-full">
            @foreach($heroSections as $heroSection)
                <div class="swiper-slide h-full relative">
                    <img src="{{ asset('storage/images/' . $heroSection->images()->first()->path) }}" alt="{{ $heroSection->title }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                        <h2 class="text-xl font-bold">{{ $heroSection->title }}</h2>
                        @if($heroSection->subtitle)
                            <p class="text-sm">{{ $heroSection->subtitle }}</p>
                        @endif
                    </div>
                </div>
            @endforeach   
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.mySwiper', {
            spaceBetween: 30,
            centeredSlides: true,
            autoHeight: false,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
        

    
        
</div>
