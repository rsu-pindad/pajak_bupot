<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-2">
  <div class="h-32 overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64">
    <div class="relative p-6 shadow-md sm:rounded-lg">
      <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col"
                class="px-6 py-3">&nbsp;</th>
            <th scope="col"
                class="px-6 py-3">Status</th>
            <th scope="col"
                class="px-6 py-3">Antrian</th>
            <th scope="col"
                class="px-6 py-3">Lokasi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transfers as $transfer)
            <tr class="py-2">
              @if (is_null($transfer->jobBatch))
                <td>
                  <svg class="h-3 w-3 text-red-500"
                       aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg"
                       fill="none"
                       viewBox="0 0 14 14">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                </td>
                <td>
                  <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-2.5 rounded-full bg-blue-600"
                         style="width: 0%"></div>
                  </div>
                </td>
              @elseif($transfer->jobBatch->hasPendingJobs())
                <td>
                  <svg class="h-3 w-3 text-red-500"
                       aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg"
                       fill="none"
                       viewBox="0 0 14 14">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                </td>
                <td>

                  <div class="h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-2.5 rounded-full bg-blue-600"
                         style="width: {{ $transfer->jobBatch->progress() / 100 }}%"></div>
                  </div>

                </td>
              @elseif($transfer->jobBatch->finished() and $transfer->jobBatch->failed())
                <td>
                  <svg class="h-3 w-3 text-red-500"
                       aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg"
                       fill="none"
                       viewBox="0 0 14 14">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                </td>
                <td>
                  Gagal
                </td>
              @elseif($transfer->jobBatch->finished() and $transfer->jobBatch->hasFailures())
                <td>
                  <svg class="h-3 w-3 text-red-500"
                       aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg"
                       fill="none"
                       viewBox="0 0 14 14">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                </td>
                <td>
                  Selesai dengan error
                </td>
              @elseif($transfer->jobBatch->finished())
                <td>
                  <svg class="h-3 w-3 text-green-500"
                       aria-hidden="true"
                       xmlns="http://www.w3.org/2000/svg"
                       fill="none"
                       viewBox="0 0 16 12">
                    <path stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5" />
                  </svg>
                </td>
                <td>
                  Berhasil
                </td>
              @endif
              <td>
                {{ $transfer->batch_id }}
              </td>
              <td>
                {{ $transfer->files_sum_size }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">
                Anda belum mempunyai antrian unggahan
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div
       class="h-32 overflow-x-auto overflow-y-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64">
    <div class="p-6">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Buat Antrian</h5>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
               for="multiple_files">Pilih file yang akan di unggah</label>
        <input id="multiple_files"
               wire:model="pendingFiles"
               class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
               type="file">
      </div>
      <div class="inline-flex w-full items-center justify-center">
        <hr class="my-3 h-px w-64 border-0 bg-gray-200 dark:bg-gray-700">
        <span class="absolute bg-white px-3 font-medium text-gray-900 dark:bg-gray-900 dark:text-white">
          Files
        </span>
      </div>
      <div class="flex flex-row">
        @forelse($pendingFiles as $pendingFile)
          {!! Avatar::create($pendingFile->getFileName())->setDimension(36)->setFontSize(18)->toSvg() !!}
        @empty
          <p>tidak ada file yang dipilih</p>
        @endforelse
      </div>
      <div class="my-3">
        @error('pendingFiles.*')
          {{ $message }}
        @enderror
      </div>
      <div class="my-6">
        <button wire:click="initiateTransfer"
                type="button"
                class="mb-2 me-2 inline-flex rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-800">
          Unggah
          <x-cui-cil-cloud-upload class="size-4 fill-current" />
        </button>
      </div>
    </div>
  </div>
</div>
