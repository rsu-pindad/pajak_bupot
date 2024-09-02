<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-2">
  <div class="h-32 overflow-x-auto rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 md:h-64">
    <div class="relative p-6 shadow-md sm:rounded-lg">
      <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col"
                class="px-6 py-3">Lokasi File</th>
            <th scope="col"
                class="px-6 py-3">Bulan Rilis</th>
            <th scope="col"
                class="px-6 py-3">Publish</th>
          </tr>
        </thead>
        <tbody>
          @forelse($dokumens as $dokumen)
            <tr class="py-2">
              @if ($dokumen->jobBatch->finished())
                <td>
                  {{$dokumen->files->pluck('path')}}
                </td>
                <td>
                    {{$dokumen->files->pluck('publish')}}
                </td>
                <td>
                    @php
                    $publish = $dokumen->files->filter(function($file){
                        return \App\Models\TransferFile::find($file);
                    });
                    @endphp
                </td>
              @endif
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
</div>
