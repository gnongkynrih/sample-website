<?php

use Livewire\Component;
use App\Models\Hero;
use App\Models\Image;
use Livewire\WithFileUploads;

new class extends Component
{
    public $title = '';
    public $subtitle = '';
    public $heroImage = '';
    public $heroes = [];
    public $editingHero = null;
    use WithFileUploads;

    public function mount()
    {
        $this->loadHeroes();
    }

    public function loadHeroes()
    {
        $this->heroes = Hero::with('images')->get();
    }

    public function saveHero()
    {
        $this->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'heroImage' => $this->editingHero ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($this->editingHero) {
            $hero = $this->editingHero;
            $hero->update([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
            ]);
            if ($this->heroImage) {
                $this->heroImage->store('images', 'public');
                $hero->images()->delete(); // Remove old image
                Image::create([
                    'path' => $this->heroImage->hashName(),
                    'document_type' => 'hero_image',
                    'imageable_type' => Hero::class,
                    'imageable_id' => $hero->id,
                ]);
            }
            session()->flash('message', 'Hero updated successfully.');
        } else {
            // Save hero section
            $hero = Hero::create([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
            ]);
            
            // Save hero image
            $this->heroImage->store('images', 'public');
            
            Image::create([
                'path' => $this->heroImage->hashName(),
                'document_type' => 'hero_image',
                'imageable_type' => Hero::class,
                'imageable_id' => $hero->id,
            ]);
            session()->flash('message', 'Hero created successfully.');
        }

        $this->resetForm();
        $this->loadHeroes();
    }

    public function editHero($id)
    {
        $hero = Hero::find($id);
        $this->editingHero = $hero;
        $this->title = $hero->title;
        $this->subtitle = $hero->subtitle;
        $this->heroImage = null; // Reset file input
    }

    public function deleteHero($id)
    {
        $hero = Hero::find($id);
        $hero->images()->delete();
        $hero->delete();
        session()->flash('message', 'Hero deleted successfully.');
        $this->loadHeroes();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->heroImage = null;
        $this->editingHero = null;
    }
};
?>

<div class="space-y-4 p-8">
    <flux:card class="space-y-6 max-w-4xl mx-auto">
        <div>
            <flux:heading size="lg">Hero Section Management</flux:heading>
            <flux:text class="mt-2">Manage your hero section content</flux:text>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- List of Heroes -->
        <div class="space-y-4">
            <flux:heading size="md">Existing Heroes</flux:heading>
            @forelse ($heroes as $hero)
                <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">{{ $hero->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $hero->subtitle }}</p>
                        @if($hero->images->first())
                            <img src="{{ asset('storage/images/' . $hero->images->first()->path) }}" alt="{{ $hero->title }}" class="w-20 h-20 object-cover mt-2">
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        <flux:button wire:click="editHero({{ $hero->id }})" variant="outline">Edit</flux:button>
                        <flux:button wire:click="deleteHero({{ $hero->id }})" variant="danger">Delete</flux:button>
                    </div>
                </div>
            @empty
                <p>No heroes found.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form wire:submit.prevent="saveHero" class="bg-linear-to-br from-purple-300 to-purple-800 p-8 rounded-2xl shadow-2xl flex flex-col border border-white/20 backdrop-blur-sm">
            <flux:heading size="md">{{ $editingHero ? 'Edit Hero' : 'Add New Hero' }}</flux:heading>
            <flux:field>
                <flux:label>Title</flux:label>
                <flux:input type="text" wire:model="title" />
                <flux:error name="title" />
            </flux:field>
            <flux:field>
                <flux:label>Subtitle</flux:label>
                <flux:input type="text" wire:model="subtitle" />
                <flux:error name="subtitle" />
            </flux:field>
            <flux:field>
                <flux:label>Hero Image {{ $editingHero ? '(leave empty to keep current)' : '' }}</flux:label>
                <flux:input 
                    type="file" 
                    wire:model="heroImage"
                    accept="image/*">
                </flux:input>
                <flux:error name="heroImage" />
            </flux:field>
            <div class="flex space-x-4 mt-6">
                <flux:button type="submit" class="bg-white text-purple-600 font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">{{ $editingHero ? 'Update' : 'Save' }}</flux:button>
                @if($editingHero)
                    <flux:button wire:click="cancelEdit" variant="outline">Cancel</flux:button>
                @endif
            </div>
        </form>
    </flux:card>
</div>