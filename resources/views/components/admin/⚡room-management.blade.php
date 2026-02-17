<?php

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomType;

new class extends Component
{
    public $room_no = '';
    public $description = '';
    public $room_type_id = '';
    public $rooms = [];
    public $allRoomTypes = [];
    public $editingRoom = null;

    public function mount()
    {
        $this->loadRooms();
        $this->allRoomTypes = RoomType::all();
    }

    public function loadRooms()
    {
        $this->rooms = Room::with('roomType')->get();
    }

    public function saveRoom()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'room_type_id' => 'required|exists:room_types,id',
        ]);
        
        if ($this->editingRoom) {
            $this->editingRoom->update([
                'room_no' => $this->room_no,
                'description' => $this->description,
                'room_type_id' => $this->room_type_id,
            ]);
            session()->flash('message', 'Room updated successfully.');
        } else {
            Room::create([
                'room_no' => $this->room_no,
                'description' => $this->description,
                'room_type_id' => $this->room_type_id,
            ]);
            session()->flash('message', 'Room created successfully.');
        }

        $this->resetForm();
        $this->loadRooms();
    }

    public function editRoom($id)
    {
        $room = Room::find($id);
        $this->editingRoom = $room;
        $this->room_no = $room->room_no;
        $this->description = $room->description;
        $this->room_type_id = $room->room_type_id;
    }

    public function deleteRoom($id)
    {
        Room::find($id)->delete();
        session()->flash('message', 'Room deleted successfully.');
        $this->loadRooms();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->room_no = '';
        $this->description = '';
        $this->room_type_id = '';
        $this->editingRoom = null;
    }
};
?>

<div class="space-y-4 p-8">
    <flux:card class="space-y-6 max-w-4xl mx-auto">
        <div>
            <flux:heading size="lg">Room Management</flux:heading>
            <flux:text class="mt-2">Manage your rooms</flux:text>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- List of Rooms -->
        <div class="space-y-4">
            <flux:heading size="md">Existing Rooms</flux:heading>
            @forelse ($rooms as $room)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold">{{ $room->room_noname }}</h3>
                            <p class="text-sm text-gray-600">{{ $room->description }}</p>
                            <p class="text-sm text-blue-600">Type: {{ $room->roomType->name ?? 'N/A' }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <flux:button wire:click="editRoom({{ $room->id }})" variant="outline">Edit</flux:button>
                            <flux:button wire:click="deleteRoom({{ $room->id }})" variant="danger">Delete</flux:button>
                        </div>
                    </div>
                </div>
            @empty
                <p>No rooms found.</p>
            @endforelse
        </div>

        <!-- Form -->
        <form wire:submit.prevent="saveRoom" class="bg-gradient-to-br from-purple-300 to-purple-800 p-8 rounded-2xl shadow-2xl flex flex-col border border-white/20 backdrop-blur-sm">
            <flux:heading size="md">{{ $editingRoom ? 'Edit Room' : 'Add New Room' }}</flux:heading>
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input type="text" wire:model="room_no" />
                <flux:error name="room_no" />
            </flux:field>
            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="4"></flux:textarea>
                <flux:error name="description" />
            </flux:field>
            <flux:field>
                <flux:label>Room Type</flux:label>
                <select wire:model="room_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Select Room Type</option>
                    @foreach($allRoomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <flux:error name="room_type_id" />
            </flux:field>
            <div class="flex space-x-4 mt-6">
                <flux:button type="submit" class="bg-white text-purple-600 font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">{{ $editingRoom ? 'Update' : 'Save' }}</flux:button>
                @if($editingRoom)
                    <flux:button wire:click="cancelEdit" variant="outline">Cancel</flux:button>
                @endif
            </div>
        </form>
    </flux:card>
</div>