<?php

namespace App\Listeners;

use App\Events\LocalTransferCreated;
use App\Events\TransferCompleted;
use App\Jobs\TransferLocalFileToCloud;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Throwable;

class CreateTransferBatch
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LocalTransferCreated $event): void
    {
        $transfer = $event->getTransfer();
        $jobs     = $transfer->files->mapInto(TransferLocalFileToCloud::class);

        $batch = Bus::batch($jobs)
                     ->finally(function () use ($transfer) {
                         TransferCompleted::dispatch($transfer);
                     })
                     ->dispatch();

        $event->getTransfer()->update([
            'batch_id' => $batch->id
        ]);
    }
}
