<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ManagePublish extends Component
{
    #[Layout('layouts.pajak')]
    public function render()
    {
        return view('livewire.manage-publish', [
            'dokumens' => auth()->user()->transfers()->with('jobBatch')->with('files')->get(),
        ]);
    }
}
