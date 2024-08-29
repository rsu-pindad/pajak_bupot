<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new 
#[Layout('layouts.pajak')]
#[Title('Halaman Bukti Potong')]
class extends Component {
    public function mount(){
        
    }
}; ?>
<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
    <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
    <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
    <div class="h-32 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64"></div>
</div>
