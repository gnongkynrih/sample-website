<?php

use App\Models\About;
use Livewire\Component;

new class extends Component
{
    public $desc;
    public function mount(){
        $about = About::first() ;
        $this->desc = $about->description ?? 'No description available';
    }
};
?>

<div>
    <p>{!! $desc !!}</p>
</div>