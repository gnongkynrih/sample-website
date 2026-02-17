<?php

use App\Models\Contact;
use Livewire\Component;

new class extends Component
{
    public $email = '';
    public $phone = '';
    public $address = '';

    public function mount(){
        $contact = Contact::first();
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->address = $contact->address;
    }
};
?>
<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
    <!-- Main two-column grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start">
      
      <!-- Left: Google Map (unchanged) -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 top-8">
        <div class="w-full h-[70vh]">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3599.1869267277434!2d91.89938487539389!3d25.56544707747577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x37507eafb008d9af%3A0xa687ba7bedfa6845!2sNIELIT%20SHILLONG!5e0!3m2!1sen!2sin!4v1771216088184!5m2!1sen!2sin" 
            class="h-full w-full"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>

      <!-- Right: Modern Contact Info with Heroicons via Flux -->
      <div class="flex flex-col justify-center">
        <div class="text-center lg:text-left mb-10">
          <h2 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
            Get in Touch
          </h2>
          <p class="mt-4 text-lg text-gray-600 max-w-xl mx-auto lg:mx-0">
            We're here to help. Reach out using any of the methods below — we usually reply within 24–48 hours.
          </p>
        </div>

        <!-- Unified modern contact list -->
        <div class="space-y-10 lg:space-y-12 bg-white rounded-2xl shadow-lg border border-gray-100/80 p-8 lg:p-10">
          
          <!-- Email -->
          <div class="group flex flex-col sm:flex-row sm:items-start gap-6 hover:bg-gray-50/70 transition-colors duration-300 rounded-xl p-4 -mx-4">
            <div class="flex-shrink-0">
              <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <!-- Flux Icon (preferred) -->
                <flux:icon.envelope class="w-8 h-8" />
                
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-semibold text-gray-900 mb-1">Email Us</h3>
              <a href="mailto:{{ $email }}" class="text-lg text-blue-600 hover:text-blue-800 font-medium break-all transition-colors">
                {{ $email }}
              </a>
              <p class="mt-2 text-gray-600 leading-relaxed">
                Best for detailed questions or attachments.
              </p>
            </div>
          </div>

          <!-- Phone -->
          <div class="group flex flex-col sm:flex-row sm:items-start gap-6 hover:bg-gray-50/70 transition-colors duration-300 rounded-xl p-4 -mx-4">
            <div class="flex-shrink-0">
              <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center text-green-600 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <flux:icon.phone class="w-8 h-8" />
                
              
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-semibold text-gray-900 mb-1">Call or Text Us</h3>
              <a href="tel:{{ $phone }}" class="text-lg text-green-600 hover:text-green-800 font-medium transition-colors">
                {{ $phone }}
              </a>
              <p class="mt-2 text-gray-600 leading-relaxed">
                Quick questions? We're available Mon–Fri, 9 AM – 6 PM IST.
              </p>
            </div>
          </div>

          <!-- Address -->
          <div class="group flex flex-col sm:flex-row sm:items-start gap-6 hover:bg-gray-50/70 transition-colors duration-300 rounded-xl p-4 -mx-4">
            <div class="flex-shrink-0">
              <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center text-red-600 shadow-sm group-hover:scale-105 transition-transform duration-300">
                <flux:icon.map-pin class="w-8 h-8" />
               
              </div>
            </div>
            <div class="flex-1">
              <h3 class="text-2xl font-semibold text-gray-900 mb-1">Visit Our Office</h3>
              <p class="text-lg text-gray-700 font-medium leading-relaxed">
                {{ $address }}
              </p>
              <p class="mt-2 text-gray-600 leading-relaxed">
                Drop by during business hours — coffee's on us!
              </p>
            </div>
          </div>

        </div>
      </div>

    </div>
</div>