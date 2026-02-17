<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <div x-data="{ open: false }" class="mb-5">
        <flux:button @click="open = ! open">Toggle</flux:button>
    
        <div x-show="open" @click.outside="open = false">Contents...</div>

         <div 
            x-show="open"
            x-data="{ count: 0 }" 
            class="mt-5">
            <flux:button x-on:click="count++">Increment</flux:button>
        
            <span x-text="count" class="px-5"></span>
            <flux:button x-on:click="count--">Decrement</flux:button>
        </div>
    </div>

   
    
</div>
