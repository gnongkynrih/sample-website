<?php

use Livewire\Component;
use App\Models\About;

new class extends Component
{
    public $description = '';

    public function mount()
    {
        $this->description = About::first()->description ?? '';
    }

    public function save()
    {
        try{
            About::updateOrCreate([], ['description' => $this->description]);
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }
};

?>

<div class="p-6 max-w-6xl mx-auto ">
    <form wire:submit.prevent="save">
        <div wire:ignore class="border border-gray-300 rounded-lg overflow-hidden">
            <div 
                x-data="{ quill: null }"
                x-init="
                    quill = new Quill($el, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'script': 'sub'}, { 'script': 'super' }],
                                [{ 'indent': '-1'}, { 'indent': '+1' }],
                                [{ 'direction': 'rtl' }],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'align': [] }],
                                {{-- ['link', 'image'], --}}
                                ['clean']
                            ]
                        },
                    });

                    // Set initial content
                    const initial = @js($this->description ?? '<p></p>');
                    quill.root.innerHTML = initial;

                    // Quill → Livewire
                    quill.on('text-change', () => {
                        $wire.set('description', quill.root.innerHTML, false);
                    });

                    // Livewire → Quill
                    $watch('$wire.description', (value) => {
                        if (quill.root.innerHTML !== value) {
                            quill.root.innerHTML = value;
                            console.log('Livewire updated Quill');
                        }
                    });
                "
            >
                <div class="min-h-[400px]"></div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <flux:button variant="primary" type="submit">Save</flux:button>
        </div>
    </form>
</div>

{{-- @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush --}}