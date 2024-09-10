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
    <style>
      .watermark {
        -webkit-transform: rotate(331deg);
        -moz-transform: rotate(331deg);
        -o-transform: rotate(331deg);
        transform: rotate(331deg);
        font-size: 8em;
        color: rgba(112, 112, 112, 0.151);
        position: fixed;
        font-family: 'serif', sans-serif;
        text-transform: uppercase;
        padding-left: 10%;
        padding-top: 10%;
      }
    </style>
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        font-family: 'serif', sans-serif;
      }
    </style>

    @vite(['resources/css/app.css'])
  </head>

  <body class="antialiased">

    <span class="watermark">PMU</span>
    <div class="mx-auto my-auto px-8 py-8">
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
          <p class="text-sm font-medium text-gray-600">PERIODE ABSENSI BULAN
            {{ \App\Enums\Bulan::from($kehadiran->kehadiran_periode_bulan)->labels() }}
            {{ $kehadiran->kehadiran_tahun }} PEMBAYARAN
            {{ \App\Enums\Bulan::from($kehadiran->kehadiran_pembayaran_bulan)->labels() }}
            {{ $kehadiran->kehadiran_tahun }}</p>
        </div>
      </div>
      <hr class="border-1 mb-1 h-px bg-gray-200 dark:bg-gray-900">
      <hr class="border-1 mb-4 h-px bg-gray-200 dark:bg-gray-900">
      <div class="mb-4 gap-4 text-sm">
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
      <div class="grid grid-cols-2 gap-4">
        <div class="grid grid-cols-4 gap-4 text-sm">
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="col-span-4 col-start-1">
              <p class="inline-block font-bold">A. KOMPONEN PERHITUNGAN KEHADIRAN</p>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">TUNJANGAN KEHADIRAN</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ number_format($kehadiran->tunjangan_kehadiran, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">JUMLAH HARI KERJA</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ $kehadiran->jumlah_hari_kerja }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">JUMLAH JAM TERBUANG</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ $kehadiran->jumlah_jam_terbuang }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">JUMLAH CUTI / SAKIT </div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ $kehadiran->jumlah_cuti }}</div>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4 text-sm">
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="col-span-4 col-start-1">
              <p class="inline-block font-bold">B. PERHITUNGAN KEHADIRAN</p>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">POTONGAN ABSENSI</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ number_format($kehadiran->potongan_absensi, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">JUMLAH PENDAPATAN</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ number_format($kehadiran->jumlah_pendapatan, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="text-gray-700">PEMBULATAN</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="text-gray-700">{{ number_format($kehadiran->jumlah_pembulatan, 2, ',', '.') }}</div>
            </div>
          </div>
          <div class="grid-cols-subgrid col-span-4 grid">
            <div class="text-nowrap col-span-2 col-start-1 text-left">
              <div class="font-bold text-gray-700">DITERIMAKAN</div>
            </div>
            <div>
              <div class="text-gray-700">:</div>
            </div>
            <div class="text-wrap text-right">
              <div class="font-bold text-gray-700">{{ number_format($kehadiran->jumlah_diterimakan, 2, ',', '.') }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="border-1 mt-4 h-px bg-gray-200 dark:bg-gray-900">
      <hr class="border-1 mt-1 h-px bg-gray-200 dark:bg-gray-900">
    </div>
  </body>

</html>
