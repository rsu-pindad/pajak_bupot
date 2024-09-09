<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Slip Kehadiran</title>

    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body>
    <div class="mx-auto my-auto bg-white px-8 py-8">
      <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
          <img class="mr-2 h-10 w-10"
               src="{{ public_path('pmu.png') }}"
               alt="Logo" />
          <div class="inline-block">
            <p class="text-lg font-semibold text-gray-700">PT PINDAD MEDIKA UTAMA</p>
            <p class="text-sm font-light text-gray-500">Jl. Jend. Gatot Soebroto No. 517 Bandung</p>
          </div>
        </div>
      </div>
      <div class="mb-2 flex items-center justify-center">
        <div class="inline-block text-center">
          <p class="text-sm font-medium text-gray-600">STRUK PEMBAYARAN TUNJANGAN KEHADIRAN</p>
          <p class="text-sm font-medium text-gray-600">PERIODE ABSENSI BULAN JUNI 2024 PEMBAYARAN JULI 2024</p>
        </div>
      </div>
      <hr class="mb-1 h-px border-0 bg-gray-200 dark:bg-gray-950">
      <hr class="mb-4 h-px border-0 bg-gray-200 dark:bg-gray-950">
      <div class="gap-4 text-sm">
        <div class="flex flex-row">
          <div class="basis-1/2">
            <div class="mb-2 text-gray-700">NAMA PEGAWAI</div>
          </div>
          <div class="basis-1/2">
            <div class="mb-2 text-gray-700">: {{ $kehadiran->nama_pegawai }}</div>
          </div>
        </div>
        <div class="flex flex-row">
          <div class="basis-1/2">
            <div class="mb-2 text-gray-700">NOMOR POKOK PEGAWAI</div>
          </div>
          <div class="basis-1/2">
            <div class="mb-2 text-gray-700">: {{ $kehadiran->npp_kehadiran }}</div>
          </div>
        </div>
      </div>
      <div class="mt-2 grid grid-cols-2">
        <div class="grid grid-cols-3 gap-4 text-sm">
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-3 col-start-1">
              <span class="inline-block font-bold">A. KOMPONEN PERHITUNGAN KEHADIRAN</span>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">TUNJANGAN KEHADIRAN</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ number_format($kehadiran->tunjangan_kehadiran, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">JUMLAH HARI KERJA</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ $kehadiran->jumlah_hari_kerja }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">JUMLAH JAM TERBUANG</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ $kehadiran->jumlah_jam_terbuang }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">JUMLAH CUTI </div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ $kehadiran->jumlah_cuti }}</div>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-3 gap-4 text-sm">
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-3 col-start-1">
              <span class="inline-block font-bold">B. PERHITUNGAN KEHADIRAN</span>
            </div>
          </div> 
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">POTONGAN ABSENSI</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ number_format($kehadiran->potongan_absensi, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">JUMLAH PENDAPATAN</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ number_format($kehadiran->jumlah_pendapatan, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="text-gray-700">PEMBULATAN</div>
            </div>
            <div class="col-start-3">
              <div class="text-gray-700">: {{ number_format($kehadiran->jumlah_pembulatan, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-3 grid">
            <div class="col-span-2 col-start-1">
              <div class="font-bold text-gray-700">DITERIMAKAN </div>
            </div>
            <div class="col-start-3">
              <div class="font-bold text-gray-700">: {{ number_format($kehadiran->jumlah_diterimakan, 2, ',', '.') }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="mt-4 h-px border-0 bg-gray-200 dark:bg-gray-950">
      <hr class="mt-1 h-px border-0 bg-gray-200 dark:bg-gray-950">
    </div>

  </body>

</html>
