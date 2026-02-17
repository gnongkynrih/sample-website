<?php

use Livewire\Component;
use App\Models\RoomType;
use App\Models\Image;
use Livewire\WithFileUploads;

new class extends Component
{
    public $name = '';
    public $number_rooms ='';
    public $price = '';
    public $description = '';
    public $roomImages = [];
    public $roomTypes = [];
    public $editingRoomType = null;
    use WithFileUploads;

    public function mount()
    {
        $this->loadRoomTypes();
    }

    public function loadRoomTypes()
    {
        $this->roomTypes = RoomType::with('images')->get();
    }

    public function saveRoomType()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'number_rooms' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:500',
            'roomImages' => $this->editingRoomType ? 'nullable' : 'required|array|min:1',
            'roomImages.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($this->editingRoomType) {
            $roomType = $this->editingRoomType;
            $roomType->update([
                'name' => $this->name,
                'description' => $this->description,
                'number_rooms' => $this->number_rooms,
                'price' => $this->price,
            ]);
            if ($this->roomImages) {
                // Remove old images
                foreach ($roomType->images as $image) {
                    // Optionally delete file from storage
                    // Storage::disk('public')->delete('images/' . $image->path);
                }
                $roomType->images()->delete();
                // Add new images
                foreach ($this->roomImages as $imageFile) {
                    $imageFile->store('images', 'public');
                    Image::create([
                        'path' => $imageFile->hashName(),
                        'document_type' => 'room_image',
                        'imageable_type' => RoomType::class,
                        'imageable_id' => $roomType->id,
                    ]);
                }
            }
            session()->flash('message', 'Room Type updated successfully.');
        } else {
            // Create new room type
            $roomType = RoomType::create([
                'name' => $this->name,
                'description' => $this->description,
                'number_rooms' => $this->number_rooms,
                'price' => $this->price,
            ]);
            // Save images
            foreach ($this->roomImages as $imageFile) {
                $imageFile->store('images', 'public');
                Image::create([
                    'path' => $imageFile->hashName(),
                    'document_type' => 'room_image',
                    'imageable_type' => RoomType::class,
                    'imageable_id' => $roomType->id,
                ]);
            }
            session()->flash('message', 'Room Type created successfully.');
        }

        $this->resetForm();
        $this->loadRoomTypes();
    }

    public function editRoomType($id)
    {
        $roomType = RoomType::find($id);
        $this->editingRoomType = $roomType;
        $this->name = $roomType->name;
        $this->description = $roomType->description;
        $this->roomImages = []; // Reset file input
    }

    public function deleteRoomType($id)
    {
        $roomType = RoomType::find($id);
        foreach ($roomType->images as $image) {
            // Storage::disk('public')->delete('images/' . $image->path);
        }
        $roomType->images()->delete();
        $roomType->delete();
        session()->flash('message', 'Room Type deleted successfully.');
        $this->loadRoomTypes();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->roomImages = [];
        $this->editingRoomType = null;
    }

    public function removeImage($index)
    {
        unset($this->roomImages[$index]);
        $this->roomImages = array_values($this->roomImages);
    }
};
?>

<div class="space-y-4 p-8">
    <flux:card class="space-y-6 max-w-4xl mx-auto">
        <div>
            <flux:heading size="lg">Room Type Management</flux:heading>
            <flux:text class="mt-2">Manage your room types with multiple images</flux:text>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- List of Room Types -->
        <div class="space-y-4">
            <flux:heading size="md">Existing Room Types</flux:heading>
            @forelse ($roomTypes as $roomType)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold">{{ $roomType->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $roomType->description }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <flux:button wire:click="editRoomType({{ $roomType->id }})" variant="outline">Edit</flux:button>
                            <flux:button wire:click="deleteRoomType({{ $roomType->id }})" variant="danger">Delete</flux:button>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2 overflow-x-auto">
                        @foreach($roomType->images as $image)
                            <img src="{{ asset('storage/images/' . $image->path) }}" alt="{{ $roomType->name }}" class="w-20 h-20 object-cover flex-shrink-0">
                        @endforeach
                    </div>
                </div>
            @empty
                <p>No room types found.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form wire:submit.prevent="saveRoomType" class="bg-gradient-to-br from-blue-300 to-blue-800 p-8 rounded-2xl shadow-2xl flex flex-col border border-white/20 backdrop-blur-sm">
            <flux:heading size="md">{{ $editingRoomType ? 'Edit Room Type' : 'Add New Room Type' }}</flux:heading>
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input type="text" wire:model="name" />
                <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="4"></flux:textarea>
                <flux:error name="description" />
            </flux:field>
             <flux:field>
                <flux:label>Number of Rooms</flux:label>
                <flux:input type="number" wire:model="number_rooms" />
                <flux:error name="number_rooms" />
            </flux:field>
             <flux:field>
                <flux:label>Price</flux:label>
                <flux:input type="number" wire:model="price"></flux:input>
                <flux:error name="price" />
            </flux:field>
            <flux:field>
                <flux:label>Room Images {{ $editingRoomType ? '(leave empty to keep current)' : '' }}</flux:label>
                <flux:input
                    type="file"
                    wire:model="roomImages"
                    multiple
                    accept="image/*">
                </flux:input>
                <flux:error name="roomImages" />
                <flux:error name="roomImages.*" />
            </flux:field>

            @if($roomImages)
            <div class="mt-4">
                <flux:heading size="sm">Image Previews</flux:heading>
                <div class="flex flex-wrap gap-4">
                    @foreach($roomImages as $index => $image)
                        <div class="relative">
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-20 h-20 object-cover border rounded">
                            <flux:button wire:click="removeImage({{ $index }})" variant="danger" class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 w-6 h-6 rounded-full flex items-center justify-center text-xs">X</flux:button>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex space-x-4 mt-6">
                <flux:button type="submit" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">{{ $editingRoomType ? 'Update' : 'Save' }}</flux:button>
                @if($editingRoomType)
                    <flux:button wire:click="cancelEdit" variant="outline">Cancel</flux:button>
                @endif
            </div>
        </form>
    </flux:card>
</div>