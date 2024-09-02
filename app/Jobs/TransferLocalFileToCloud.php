<?php

namespace App\Jobs;

use App\Events\FileTransferredToCloud;
use App\Models\TransferFile;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TransferLocalFileToCloud implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private TransferFile $file)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cloudPath = Storage::disk('public')->put('dokumen', new File($localPath = $this->file->path), $this->file->getClientOriginalName . $this->file->getClientOriginalExtension);

        $this->file->update([
            'disk' => 'public',
            'path' => $cloudPath,
        ]);

        Storage::disk('public')->delete($localPath);
        FileTransferredToCloud::dispatch($this->file);
    }
}
