<?php
use Livewire\Component;
use App\Models\RoomType;

new class extends Component
{
    public $roomTypes = [];

    public function mount()
    {
        $this->roomTypes = RoomType::where('is_available', true)
            ->with('images')
            ->get();
    }
};
?>

<div x-data="{ scrollY: 0 }" 
     x-on:scroll.window.debounce.50="scrollY = window.scrollY"
     class="relative py-16 px-10 text-center overflow-hidden min-h-[600px]">

    <!-- Parallax Background Layer -->
    <div class="absolute inset-0 bg-cover bg-center z-0 transition-transform duration-300 ease-out"
         :style="{ transform: 'translateY(' + (scrollY * 0.4) + 'px)' }"
         style="background-image: url('{{ asset('images/hotel-interior-bg.jpg') }}');">  <!-- ← your image -->
    </div>

    <!-- Overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/50 to-blue-800/60 z-10"></div>

    <!-- Foreground Content -->
    <div class="relative z-20 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold mb-10 text-white relative inline-block pb-4">
            Room Types
            <span class="absolute left-1/2 -translate-x-1/2 bottom-0 w-24 h-1 bg-white"></span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
    @foreach($roomTypes as $room)
        <div 
            class="bg-white rounded-lg shadow-md overflow-hidden 
                   animate__animated animate__fadeInLeft"
            style="animation-delay: {{ $loop->index * 0.2 }}s;"
        >
            <img src="{{ asset('storage/images/' . $room->images->first()->path) }}" 
                 alt="{{ $room->name }}" 
                 class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">{{ $room->name }}</h3>
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-green-600">${{ $room->price }}</span>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Book Now
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>