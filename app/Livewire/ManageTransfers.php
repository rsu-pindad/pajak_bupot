<?php

namespace App\Livewire;

use App\Events\LocalTransferCreated;
use App\Models\TransferFile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageTransfers extends Component
{
    use WithFileUploads;

    public $pendingFiles = [];

    public function getListeners()
    {
        $userId = auth()->id();

        return [
            "echo-private:notifications.{$userId},FileTransferredToCloud" => '$refresh',
            "echo-private:notifications.{$userId},TransferCompleted"      => 'fireConfettiCannon',
        ];
    }

    #[Layout('layouts.pajak')]
    public function render()
    {
        return view('livewire.manage-transfers', [
            'transfers' => auth()->user()->transfers()->with('jobBatch')->withSum('files', 'size')->get(),
        ]);
    }

    public function initiateTransfer()
    {
        $this->validate([
            'pendingFiles.*' => ['file']
        ]);

        $transfer = auth()->user()->transfers()->create();
        $transfer->files()->saveMany(
            collect($this->pendingFiles)
                ->map(function (TemporaryUploadedFile $pendingFile) {
                    return new TransferFile([
                        'disk' => 'public',
                        // 'disk' => $pendingFile->disk,
                        'path' => $pendingFile->getRealPath(),
                        'size' => $pendingFile->getSize(),
                    ]);
                })
        );
        $this->pendingFiles = [];

        LocalTransferCreated::dispatch($transfer);
    }

    public function fireConfettiCannon()
    {
        $this->reset('pendingFiles');
        $this->dispatch('confetti');
    }
}
